<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require_once("../db.php");
require '../vendor/autoload.php'; // PHPMailer autoload if you use Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["reset_error"] = "Please enter a valid email.";
        header("Location: ../view/forgot_password.php");
        exit;
    }

    $conn = createCon();
    $sql = "SELECT id FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        $_SESSION["reset_error"] = "Email not found.";
        header("Location: ../view/forgot_password.php");
        exit;
    }

    // Generate secure token
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+15 minutes"));

    // Insert or update token
    $sql = "INSERT INTO password_resets (email, token, expires_at)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE token=?, expires_at=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $email, $token, $expires, $token, $expires);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    closeCon($conn);

    // Send email
    $resetLink = "http://localhost/webtech%20project/view/reset_password.php?token=$token";

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mkbadhon500@gmail.com'; // your Gmail
        $mail->Password   = 'mzaluhhirezlkfkx'; // your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('mkbadhon500@gmail.com', 'Personal Finance Tracker');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";

        $mail->send();
        $_SESSION["reset_message"] = "Password reset link has been sent to your email.";
    } catch (Exception $e) {
        $_SESSION["reset_error"] = "Could not send email. Mailer Error: {$mail->ErrorInfo}";
    }

    header("Location: ../view/forgot_password.php");
    exit;
}
?>
