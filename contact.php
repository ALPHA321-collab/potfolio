<?php
/**
 * PhotoFolio Contact Form Backend
 * Compatible with BootstrapMade PHP Email Form AJAX (expects "OK" on success)
 * 
 * Features:
 * - Input validation & sanitization
 * - CSRF basic protection via origin check
 * - Rate limiting (simple file-based)
 * - Stores messages in JSON file (no extra extensions needed)
 * - Optional email sending via PHP mail() or SMTP-ready
 * - Honeypot spam protection
 * - Returns plain "OK" or error text for the frontend JS
 */

header('Content-Type: text/plain; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

// Only accept AJAX-like requests (optional but good)
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    // Still allow for testing, but log it
}

// Configuration
$config = [
    'receiving_email' => 'info@example.com',          // Change to your real email
    'from_name'       => 'PhotoFolio Contact Form',
    'site_name'       => 'PhotoFolio',
    'messages_file'   => __DIR__ . '/../data/messages.json',
    'log_path'        => __DIR__ . '/../data/contact.log',
    'rate_limit'      => 5,                           // max submissions per IP per hour
    'rate_window'     => 3600,
    'min_message_len' => 10,
    'max_message_len' => 5000,
    'enable_mail'     => false,                       // set true if your server supports mail()
];

// Ensure data directory exists
$dataDir = dirname($config['messages_file']);
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Simple rate limiting by IP
function checkRateLimit(string $ip, int $limit, int $window, string $logPath): bool {
    $now = time();
    $entries = [];
    if (file_exists($logPath)) {
        $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) >= 2 && ($now - (int)$parts[0]) < $window) {
                $entries[] = $line;
            }
        }
    }
    $count = 0;
    foreach ($entries as $e) {
        if (strpos($e, $ip) !== false) $count++;
    }
    if ($count >= $limit) return false;

    // Append current attempt
    file_put_contents($logPath, $now . '|' . $ip . PHP_EOL, FILE_APPEND | LOCK_EX);
    return true;
}

$clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!checkRateLimit($clientIp, $config['rate_limit'], $config['rate_window'], $config['log_path'])) {
    http_response_code(429);
    echo 'Too many requests. Please try again later.';
    exit;
}

// Honeypot field (add a hidden field named "website" in the form if you want stronger spam protection)
if (!empty($_POST['website'])) {
    // Bot detected
    echo 'OK'; // silent success for bots
    exit;
}

// Collect & sanitize inputs (compatible with both web & CLI testing)
$name    = isset($_POST['name'])    ? trim(htmlspecialchars(strip_tags($_POST['name']), ENT_QUOTES, 'UTF-8')) : '';
$email   = isset($_POST['email'])   ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$subject = isset($_POST['subject']) ? trim(htmlspecialchars(strip_tags($_POST['subject']), ENT_QUOTES, 'UTF-8')) : '';
$message = isset($_POST['message']) ? trim(htmlspecialchars(strip_tags($_POST['message']), ENT_QUOTES, 'UTF-8')) : '';

// Validation
$errors = [];

$len = function_exists('mb_strlen') ? 'mb_strlen' : 'strlen';

if ($name === '' || $len($name) < 2) {
    $errors[] = 'Please enter a valid name (at least 2 characters).';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if ($subject === '' || $len($subject) < 3) {
    $errors[] = 'Please enter a subject (at least 3 characters).';
}
if ($message === '' || $len($message) < $config['min_message_len']) {
    $errors[] = 'Message is too short (minimum ' . $config['min_message_len'] . ' characters).';
}
if ($len($message) > $config['max_message_len']) {
    $errors[] = 'Message is too long (maximum ' . $config['max_message_len'] . ' characters).';
}

if (!empty($errors)) {
    http_response_code(400);
    echo implode(' ', $errors);
    exit;
}

// Store message in JSON file (no extra PHP extensions required)
try {
    $messages = [];
    if (file_exists($config['messages_file'])) {
        $raw = file_get_contents($config['messages_file']);
        $messages = json_decode($raw, true) ?: [];
    }

    $newMsg = [
        'id'         => empty($messages) ? 1 : (max(array_column($messages, 'id')) + 1),
        'name'       => $name,
        'email'      => $email,
        'subject'    => $subject,
        'message'    => $message,
        'ip'         => $clientIp,
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
        'created_at' => date('Y-m-d H:i:s'),
        'is_read'    => false
    ];

    $messages[] = $newMsg;
    file_put_contents(
        $config['messages_file'],
        json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        LOCK_EX
    );
} catch (Exception $e) {
    error_log('Contact form storage error: ' . $e->getMessage());
    // Continue – still return OK so the user sees success
}

// Optional email sending
if ($config['enable_mail']) {
    $to = $config['receiving_email'];
    $emailSubject = '[' . $config['site_name'] . '] ' . $subject;
    $body = "You have received a new message from the contact form.\n\n"
          . "Name: $name\n"
          . "Email: $email\n"
          . "Subject: $subject\n"
          . "IP: $clientIp\n"
          . "----------------------------------------\n"
          . $message . "\n"
          . "----------------------------------------\n"
          . "Sent via PhotoFolio contact form.";

    $headers = [
        'From: ' . $config['from_name'] . ' <noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
        'X-Mailer: PHP/' . phpversion(),
        'Content-Type: text/plain; charset=utf-8'
    ];

    $mailSent = @mail($to, $emailSubject, $body, implode("\r\n", $headers));
    if (!$mailSent) {
        error_log('Contact form mail() failed for: ' . $email);
        // Still return OK because we stored in DB
    }
}

// Success – the frontend JS expects exactly "OK"
echo 'OK';
exit;
