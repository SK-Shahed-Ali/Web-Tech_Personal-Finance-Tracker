<?php
require_once("../db.php");

function insertBudget($user_id, $category, $goal_amount, $goal_month) {
    $conn = createCon();
    $sql = "INSERT INTO budget_goals (user_id, category, goal_amount, goal_month)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isds", $user_id, $category, $goal_amount, $goal_month);
    $status = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $status;
}


function getAllBudgets() {
    $conn = createCon();
    $sql = "SELECT * FROM budget_goals ORDER BY goal_month DESC";
    $result = mysqli_query($conn, $sql);
    $budgets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
    return $budgets;
}
function getBudgetById($id) {
    $conn = createCon();
    $sql = "SELECT * FROM budget_goals WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $budget = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $budget;
}

function updateBudget($id, $category, $goal_amount, $goal_month) {
    $conn = createCon();
    $sql = "UPDATE budget_goals SET category=?, goal_amount=?, goal_month=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sdsi", $category, $goal_amount, $goal_month, $id);
    $status = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $status;
}

function deleteBudget($id) {
    $conn = createCon();
    $sql = "DELETE FROM budget_goals WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $status = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $status;
}
?>
