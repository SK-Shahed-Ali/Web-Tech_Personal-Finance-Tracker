<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
  <header>Forgot Password</header>
  <div class="container">
    <?php
    session_start();
    if (isset($_SESSION["reset_message"])) {
      echo "<p style='color: green'>".$_SESSION["reset_message"]."</p>";
      unset($_SESSION["reset_message"]);
    }
    if (isset($_SESSION["reset_error"])) {
      echo "<p style='color: red'>".$_SESSION["reset_error"]."</p>";
      unset($_SESSION["reset_error"]);
    }
    ?>
    <form action="../controller/forgotPasswordController.php" method="post">
      <input type="email" name="email" placeholder="Enter your registered email" required>
      <button type="submit">Send Reset Link</button>
    </form>
    <nav><a href="login.php">Back to Login</a></nav>
  </div>
</body>
</html>
