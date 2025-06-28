<?php require_once("../auth.php"); ?>
<?php
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../model/incomeModel.php");
$currentIncomeData = getIncome($_SESSION["user_id"]);
$currentAmount = htmlspecialchars($currentIncomeData['amount']);
$currentMonth = htmlspecialchars($currentIncomeData['income_month']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../css/style1.css">
</head>
<body>
  <header>
    <div class="header-left">
      Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!
    </div>
    <div class="header-right">
      <a href="../controller/logoutController.php">Logout</a>
    </div>
  </header>

  <div class="dashboard-container">
    <div class="card balance">
      <h2>Set Income</h2>
      <p>
        Tk <?= $currentAmount ?>
        (<?= $currentMonth ?>)
      </p>
      <button class="edit-btn">Edit Income</button>
      <form class="income-edit-form" action="../controller/incomeController.php" method="post">
        <input type="number" name="amount" min="0" step="0.01" placeholder="Enter new income" required>
        <input type="month" name="income_month" required>
        <button type="submit">Save</button>
      </form>
    </div>
    <div class="card budget">
      <h2>Set Budget Goals</h2>
      <a href="budget.php">Go to Budget</a>
    </div>

    <div class="card report">
      <h2>View Reports</h2>
      <a href="report.php">View Reports</a>
    </div>

    <div class="card export">
      <h2>Export Data</h2>
      <a href="export.php">Export Now</a>
    </div>
  </div>
</body>
</html>
