<?php require_once("../auth.php"); ?>
<?php
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Data</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
<header>Export Finance Data</header>
<div class="container">
    <h3>Download Your Finance Records</h3>
    <form action="../controller/exportController.php" method="post">
        <label for="format">Select Format:</label>
        <select name="format" id="format" required>
            <option value="">Select Format</option>
            <option value="csv">CSV (Excel)</option>
        </select>
        <button type="submit">Download</button>
    </form>

    <nav><a href="home.php">Back to Dashboard</a></nav>
</div>
</body>
</html>
