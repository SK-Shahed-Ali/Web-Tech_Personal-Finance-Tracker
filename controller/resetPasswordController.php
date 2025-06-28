<?php
session_start();
require_once("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $email = $_POST["email"];
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm"]);

    if (empty($password) || empty($confirm)) {
        $_SESSION["reset_error"] = "All fields are required.";
        header("Location: ../view/reset_password.php?token=$token");
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION["reset_error"] = "Passwords do not match.";
        header("Location: ../view/reset_password.php?token=$token");
        exit;
    }

    // Validate token again
    $conn = createCon();
    $sql = "SELECT expires_at FROM password_resets WHERE token=? AND email=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $token, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if (!$data || strtotime($data["expires_at"]) < time()) {
        echo "Invalid or expired token.";
        exit;
    }

    // Update password
    $sql = "UPDATE user SET pasword=? WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $password, $email);
    mysqli_stmt_execute($stmt);

    // Clean up token
    $sql = "DELETE FROM password_resets WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    closeCon($conn);

    $_SESSION["reset_message"] = "Password updated successfully. You can log in now.";
    header("Location: ../view/login.php");
    exit;
}
?>
