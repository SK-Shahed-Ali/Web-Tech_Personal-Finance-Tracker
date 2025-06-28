<?php require_once("../auth.php"); ?>
<?php
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../model/reportModel.php");

$userId = $_SESSION["user_id"];
$selectedMonth = isset($_GET["month"]) ? $_GET["month"] : date("Y-m");

$incomeAmount = getIncomeForMonth($userId, $selectedMonth);
$expensesByCategory = getExpensesByCategory($userId, $selectedMonth);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports and Graphs</title>
    <link rel="stylesheet" href="../css/style3.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>Income vs Expense Report - <?php echo htmlspecialchars($selectedMonth); ?></header>
<div class="container">
    <form method="get" action="report.php">
        <label>Select Month:</label>
        <input type="month" name="month" value="<?php echo htmlspecialchars($selectedMonth); ?>">
        <button type="submit">Show</button>
    </form>

    <canvas id="incomeExpenseChart" width="400" height="200"></canvas>
    <br>
    <canvas id="categoryChart" width="400" height="200"></canvas>

    <nav><a href="home.php">Back to Dashboard</a></nav>
</div>

<script>
const incomeAmount = <?php echo (float)$incomeAmount; ?>;
const categories = <?php echo json_encode(array_column($expensesByCategory, 'category')); ?>;
const expenses = <?php echo json_encode(array_column($expensesByCategory, 'total_category_expense')); ?>;
const totalExpense = expenses.reduce((a,b)=>parseFloat(a)+parseFloat(b),0);

const ctx1 = document.getElementById('incomeExpenseChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Income', 'Expense'],
        datasets: [{
            label: 'Amount',
            data: [incomeAmount, totalExpense],
            backgroundColor: ['green', 'red']
        }]
    }
});

const ctx2 = document.getElementById('categoryChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: categories,
        datasets: [{
            label: 'Expenses by Category',
            data: expenses,
            backgroundColor: ['orange', 'blue', 'purple', 'teal', 'pink', 'yellow']
        }]
    }
});
</script>
</body>
</html>
