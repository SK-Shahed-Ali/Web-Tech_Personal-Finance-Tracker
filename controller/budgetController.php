<?php
session_start();
require_once("../model/budgetModel.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Make sure the user is logged in
    if (!isset($_SESSION["user_id"])) {
        header("Location: ../view/login.php");
        exit;
    }

    $user_id = $_SESSION["user_id"];

    if (isset($_POST["action"])) {
        if ($_POST["action"] === "delete") {
            $id = intval($_POST["id"]);
            // Optional: you could add ownership check before deleting
            deleteBudget($id);
            header("Location: ../view/budget.php");
            exit;
        }

        if ($_POST["action"] === "update") {
            $id = intval($_POST["id"]);
            $category = trim($_POST["category"]);
            $goal_amount = trim($_POST["goal_amount"]);
            $goal_month = $_POST["goal_month"];

            if ($category && $goal_amount && $goal_month) {
                updateBudget($id, $category, $goal_amount, $goal_month);
                header("Location: ../view/budget.php");
                exit;
            } else {
                echo "All fields are required!";
                exit;
            }
        }
    } else {
        // INSERT NEW RECORD
        $category = trim($_POST["category"]);
        $goal_amount = trim($_POST["goal_amount"]);
        $goal_month = $_POST["goal_month"];

        if ($category && $goal_amount && $goal_month) {
            insertBudget($user_id, $category, $goal_amount, $goal_month);
            header("Location: ../view/budget.php");
            exit;
        } else {
            echo "All fields are required!";
            exit;
        }
    }
}
?>
