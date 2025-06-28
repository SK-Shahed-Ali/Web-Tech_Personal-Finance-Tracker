<?php
session_start();
require_once("../db.php");

$token = $_GET['token'] ?? '';

if (!$token) {
    echo "Invalid reset link.";
    exit;
}

$conn = createCon();
$sql = "SELECT email, expires_at FROM password_resets WHERE token=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Invalid or expired reset link.";
    exit;
}

if (strtotime($data["expires_at"]) < time()) {
    echo "Reset link has expired.";
    exit;
}
$email = $data["email"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
  <header>Reset Your Password</header>
  <div class="container">
    <?php
    if (isset($_SESSION["reset_error"])) {
        echo "<p style='color:red'>".$_SESSION["reset_error"]."</p>";
        unset($_SESSION["reset_error"]);
    }
    ?>
    <form action="../controller/resetPasswordController.php" method="post">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
      <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
      <input type="password" name="password" placeholder="New Password" required>
      <input type="password" name="confirm" placeholder="Confirm Password" required>
      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
