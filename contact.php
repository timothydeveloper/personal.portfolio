<?php

$conn = new mysqli("localhost", "root", "", "portfolio_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$step = 1;
$name = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['step1'])) {
        $name = htmlspecialchars(trim($_POST['name']));
        $step = 2;
    } elseif (isset($_POST['step2'])) {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $success = "Thank you, $name! Your message has been sent.";
        } else {
            $success = "Oops! Something went wrong. Please try again.";
        }

        $stmt->close();
        $step = 2;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Page</title>
  <link rel="stylesheet" href="stylecontact.css">
</head>
<body>
  <a href="index.html" class="back-home-btn">Back to Home</a>
  <div class="center-wrapper">
    <section class="contact" id="contact">
      <div class="max-width">
        <div class="max-width">
      <h2 class="title">Contact Me</h2>

      <?php if ($step === 1): ?>
        <form method="POST" action="">
          <div class="field">
            <input type="text" name="name" placeholder="Enter your name" required>
          </div>
          <div class="button-area">
            <button type="submit" name="step1">Continue</button>
          </div>
        </form>

      <?php elseif ($step === 2): ?>
        <div class="text" style="font-size: 22px; font-weight: 500; margin-bottom: 20px;">
          Welcome <span style="color: crimson;"><?= $name ?></span> to my Portfolio!
        </div>

        <?php if ($success): ?>
          <p class="success-message"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="">
          <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
          <div class="field">
            <input type="email" name="email" placeholder="Your Email" required>
          </div>
          <div class="field textarea">
            <textarea name="message" placeholder="Your Message" required></textarea>
          </div>
          <div class="button-area">
            <button type="submit" name="step2">Send Message</button>
          </div>
        </form>
      <?php endif; ?>
      
    </div>
      </div>
    </section>
  </div>
</body>
</html>