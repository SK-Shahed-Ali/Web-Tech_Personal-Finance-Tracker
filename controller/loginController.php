<?php
session_start();
require_once("../model/userModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $result = checkLogin($email, $password);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $user["name"];
        $_SESSION["user_id"] = $user["id"];
        header("Location: ../view/home.php");
        exit;
    } else {
        $_SESSION["login_error"] = "Invalid email or password";
        header("Location: ../view/login.php");
        exit;
    }
}
?>
