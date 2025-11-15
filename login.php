<?php
session_start();
// admin password: 123456
include 'db.php';
$error = "";
if (!$pdo) {
    die("Database connection not established.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <form method="POST">
      <?php if ($error): ?>
      <p style="color: crimson; font-weight: 500;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?> 
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div style="margin-top: 15px;">
      <a href="index.html" style="color: crimson; text-decoration: none; font-weight: 500;">
        ← Back to Homepage
      </a>
    </div>
  </div>
</body>
</html>
