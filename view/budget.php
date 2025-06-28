<?php require_once("../auth.php"); ?>
<?php
require_once("../model/budgetModel.php");
$budgets = getAllBudgets();

$editingBudget = null;
if (isset($_GET["edit_id"])) {
    $editingBudget = getBudgetById($_GET["edit_id"]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Budget Goals</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
<header>Set Your Budget Goals</header>
<div class="container">

    <?php if ($editingBudget): ?>
        <form action="../controller/budgetController.php" method="post">
            <h3>Edit Budget</h3>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editingBudget['id']) ?>">
            <input type="hidden" name="action" value="update">
            <input type="text" name="category" value="<?= htmlspecialchars($editingBudget['category']) ?>" required>
            <input type="number" name="goal_amount" value="<?= htmlspecialchars($editingBudget['goal_amount']) ?>" required>
            <input type="month" name="goal_month" value="<?= htmlspecialchars($editingBudget['goal_month']) ?>" required>
            <button type="submit">Update Budget</button>
            <a href="budget.php">Cancel</a>
        </form>
    <?php else: ?>
        <form action="../controller/budgetController.php" method="post">
            <h3>Set Budget</h3>
            <input type="text" name="category" placeholder="Category (e.g. Food, Travel)" required>
            <input type="number" name="goal_amount" placeholder="Budget Amount" required>
            <input type="month" name="goal_month" required>
            <button type="submit">Save Budget</button>
        </form>
    <?php endif; ?>

    <h3>Current Budget Goals</h3>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Month</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($budgets)): ?>
            <?php foreach ($budgets as $budget): ?>
                <tr>
                    <td><?= htmlspecialchars($budget['category']) ?></td>
                    <td>Tk <?= htmlspecialchars($budget['goal_amount']) ?></td>
                    <td><?= htmlspecialchars($budget['goal_month']) ?></td>
                    <td>
                        <a href="budget.php?edit_id=<?= $budget['id'] ?>">Edit</a>
                        <form action="../controller/budgetController.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $budget['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">No budget records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <nav><a href="home.php">Back to Dashboard</a></nav>
</div>
</body>
</html>
