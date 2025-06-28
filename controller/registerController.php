<?php
session_start();
require_once("../model/userModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm"]);

    $errors = [];

    if (empty($name)) { $errors["name"] = "* Name is required"; }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors["email"] = "* Valid email is required"; }
    if (empty($password)) { $errors["password"] = "* Password is required"; }
    if (empty($confirm)) { $errors["confirm"] = "* Confirm Password is required"; }
    if ($password !== $confirm) { $errors["confirm"] = "* Passwords do not match"; }

    if (empty($errors)) {
        if (checkEmailExists($email)) {
            $errors["email"] = "* This email is already registered";
            $_SESSION['errors'] = $errors;
            header("Location: ../view/register.php");
            exit;
        } else {
            insertUser($name, $email, $password);
            header("Location: ../view/login.php");
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../view/register.php");
        exit;
    }
}
?>
