<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../view/login.php");
    exit;
}

require_once("../db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["format"] === "csv") {
    $userId = $_SESSION["user_id"];
    $conn = createCon();

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="finance_data.csv"');

    $output = fopen("php://output", "w");

    // Income
    fputcsv($output, ["Income Records"]);
    fputcsv($output, ["Month", "Amount"]);

    $incomeSql = "SELECT income_month, amount FROM income WHERE user_id = ? ORDER BY income_month DESC";
    $stmt = mysqli_prepare($conn, $incomeSql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [$row["income_month"], $row["amount"]]);
    }
    fputcsv($output, []); // Empty line

    // Expenses
    fputcsv($output, ["Budget Goals / Expenses"]);
    fputcsv($output, ["Category", "Amount", "Month"]);

    $expenseSql = "SELECT category, goal_amount, goal_month FROM budget_goals WHERE user_id = ? ORDER BY goal_month DESC";
    $stmt = mysqli_prepare($conn, $expenseSql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [$row["category"], $row["goal_amount"], $row["goal_month"]]);
    }

    fclose($output);
    exit;
}
?>
