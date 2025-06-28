<?php
session_start();
require_once("../model/incomeModel.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION["user_id"];
    $amount = $_POST["amount"];
    $incomeMonth = $_POST["income_month"];

    if (is_numeric($amount) && $amount >= 0) {
        setIncome($userId, $amount, $incomeMonth);
        header("Location: ../view/home.php");
        exit;
    } else {
        $_SESSION["income_error"] = "Invalid income amount.";
        header("Location: ../view/home.php");
        exit;
    }
}
?>


