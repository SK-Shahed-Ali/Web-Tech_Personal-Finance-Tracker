<?php
require_once("../db.php");

function getIncome($userId) {
    $conn = createCon();
    $sql = "SELECT amount, income_month
            FROM income
            WHERE user_id = ?
            ORDER BY updated_at DESC
            LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $data ?: ["amount" => 0, "income_month" => ""];
}


function setIncome($userId, $amount, $incomeMonth) {
    $conn = createCon();
    $sql = "INSERT INTO income (user_id, amount, income_month)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE amount = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "idsd", $userId, $amount, $incomeMonth, $amount);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
