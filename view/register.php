<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div id="form_container">
        <h1>Sign Up</h1>
        <form action="../controller/registerController.php" method="post">

            <div class="form-group">
                <input type="text" name="name">
                <label>Name</label>
                <span><?php echo $errors['name'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <input type="text" name="email">
                <label>Email</label>
                <span><?php echo $errors['email'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <input type="password" name="password">
                <label>Password</label>
                <span><?php echo $errors['password'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <input type="password" name="confirm">
                <label>Confirm Password</label>
                <span><?php echo $errors['confirm'] ?? ''; ?></span>
            </div>

            <button type="submit">Register</button>

            <div class="bottom-links">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>

        </form>
    </div>
</body>
</html>
