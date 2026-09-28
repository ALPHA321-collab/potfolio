<?php
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

// Sanitize inputs
$name    = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$name || !$email || !$subject || !$message) {
    echo "Please provide valid inputs for all fields.";
    exit;
}

try {
    // Save submission to database
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);

    // Optional email notification
    $to = "info@example.com";
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n";
    $body = "New message received from PhotoFolio contact form:\n\n"
          . "Name: $name\n"
          . "Email: $email\n"
          . "Subject: $subject\n\n"
          . "Message:\n$message\n";

    @mail($to, "Contact Form: " . $subject, $body, $headers);

    // BootstrapMade validate.js looks for 'OK' to display the success message
    echo "OK";
} catch (Exception $e) {
    echo "Error processing your request: " . $e->getMessage();
}
