<?php
require_once("../db.php");

function getIncomeForMonth($user_id, $month) {
    $conn = createCon();
    $sql = "SELECT SUM(amount) AS total_income
            FROM income
            WHERE user_id = ? AND income_month = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $month);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total_income);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $total_income ?: 0;
}

function getExpensesByCategory($user_id, $month) {
    $conn = createCon();
    $sql = "SELECT category, SUM(goal_amount) AS total_category_expense
            FROM budget_goals
            WHERE user_id = ? AND goal_month = ?
            GROUP BY category";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $month);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $data;
}
?>
