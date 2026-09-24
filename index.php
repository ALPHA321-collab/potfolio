<?php
/**
 * Simple Admin Panel - View Contact Messages
 * Password protected (change the password below!)
 * Access: /admin/   or  /admin/index.php
 * Storage: data/messages.json (no database extension required)
 */

session_start();

// ============ CHANGE THIS PASSWORD ============
$ADMIN_PASSWORD = 'admin123';   // Change to a strong password!
// =============================================

$messagesFile = __DIR__ . '/../data/messages.json';

// Login handling
if (isset($_POST['password'])) {
    if ($_POST['password'] === $ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $loginError = 'Incorrect password';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

$loggedIn = !empty($_SESSION['admin_logged_in']);

// Helper to load / save messages
function loadMessages(string $file): array {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

function saveMessages(string $file, array $messages): void {
    file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

// Mark as read / delete actions
if ($loggedIn && isset($_GET['action'], $_GET['id'])) {
    $messages = loadMessages($messagesFile);
    $id = (int)$_GET['id'];
    foreach ($messages as $i => $m) {
        if ((int)$m['id'] === $id) {
            if ($_GET['action'] === 'read') {
                $messages[$i]['is_read'] = true;
            } elseif ($_GET['action'] === 'delete') {
                array_splice($messages, $i, 1);
            }
            break;
        }
    }
    saveMessages($messagesFile, $messages);
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Contact Messages | PhotoFolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f4f6f9; }
    .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
    .unread { border-left: 4px solid #0d6efd; }
    .msg-body { white-space: pre-wrap; background: #f8f9fa; padding: 1rem; border-radius: .5rem; }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">PhotoFolio – Contact Messages</h1>
    <?php if ($loggedIn): ?>
      <a href="?logout=1" class="btn btn-outline-secondary btn-sm">Logout</a>
    <?php endif; ?>
  </div>

<?php if (!$loggedIn): ?>
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4">
        <h5 class="mb-3">Admin Login</h5>
        <?php if (!empty($loginError)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required autofocus>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-muted small mt-3 mb-0">Default password: <code>admin123</code> – change it in <code>admin/index.php</code></p>
      </div>
    </div>
  </div>
<?php else: ?>

  <?php
  $messages = loadMessages($messagesFile);
  // newest first
  usort($messages, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
  ?>

  <?php if (empty($messages)): ?>
    <div class="alert alert-info">No messages yet. Submit the contact form to see them here.</div>
  <?php else: ?>
    <p class="text-muted"><?= count($messages) ?> message(s)</p>
    <?php foreach ($messages as $m): ?>
      <div class="card mb-3 <?= empty($m['is_read']) ? 'unread' : '' ?>">
        <div class="card-body">
          <div class="d-flex justify-content-between flex-wrap gap-2">
            <div>
              <h5 class="card-title mb-1"><?= htmlspecialchars($m['subject'] ?? '') ?></h5>
              <p class="mb-1 text-muted small">
                From: <strong><?= htmlspecialchars($m['name'] ?? '') ?></strong>
                &lt;<?= htmlspecialchars($m['email'] ?? '') ?>&gt;
                · <?= htmlspecialchars($m['created_at'] ?? '') ?>
                · IP: <?= htmlspecialchars($m['ip'] ?? '-') ?>
              </p>
            </div>
            <div class="text-end">
              <?php if (empty($m['is_read'])): ?>
                <a href="?action=read&id=<?= (int)$m['id'] ?>" class="btn btn-sm btn-outline-primary">Mark read</a>
              <?php endif; ?>
              <a href="?action=delete&id=<?= (int)$m['id'] ?>" class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Delete this message?')">Delete</a>
            </div>
          </div>
          <div class="msg-body mt-3"><?= htmlspecialchars($m['message'] ?? '') ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

<?php endif; ?>
</div>
</body>
</html>
