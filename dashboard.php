<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}


$stmt = $pdo->query("SELECT name, email, message, created_at FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h2>Welcome to the Admin Dashboard</h2>

    <h3>Contact Messages</h3>
    <table border="1" cellpadding="10" cellspacing="0">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Date Sent</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($messages): ?>
          <?php foreach ($messages as $msg): ?>
            <tr>
              <td><?= htmlspecialchars($msg['name']) ?></td>
              <td><?= htmlspecialchars($msg['email']) ?></td>
              <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
              <td><?= htmlspecialchars($msg['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">No messages found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <form method="POST" action="logout.php" style="margin-top:20px;">
      <button type="submit">Logout</button>
    </form>
  </div>
</body>
</html>
