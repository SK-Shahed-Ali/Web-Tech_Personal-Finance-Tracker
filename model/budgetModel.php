<?php
require_once("../db.php");

function insertBudget($userId, $category, $goal_amount, $goal_month) {
    $conn = createCon();
    $sql = "INSERT INTO budget_goals (user_id, category, goal_amount, goal_month) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isds", $userId, $category, $goal_amount, $goal_month);
    $status = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $status;
}

function getAllBudgets($userId) {
    $conn = createCon();
    $sql = "SELECT * FROM budget_goals WHERE user_id = ? ORDER BY goal_month DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $budgets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $budgets;
}

function deleteBudget($id, $userId) {
    $conn = createCon();
    $sql = "DELETE FROM budget_goals WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $userId);
    $status = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $status;
}

function updateBudget($id, $userId, $category, $goal_amount, $goal_month) {
    $conn = createCon();
    $sql = "UPDATE budget_goals SET category = ?, goal_amount = ?, goal_month = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sdsii", $category, $goal_amount, $goal_month, $id, $userId);
    $status = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $status;
}

function getBudgetById($id, $userId) {
    $conn = createCon();
    $sql = "SELECT * FROM budget_goals WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $budget = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $budget;
}

?>
