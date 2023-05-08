<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">You have been logged out</h2>
        <p class="text-center">Thank you for using our application. You have successfully logged out.</p>
        <div class="text-center">
            <a href="login.php" class="btn btn-primary">Log in again</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
