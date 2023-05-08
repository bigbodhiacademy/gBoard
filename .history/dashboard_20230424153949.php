<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $user['username']; ?></h2>

    <?php if ($user['user_role'] === 'super_user'): ?>
        <h3>Create a new user</h3>
        <form action="create_user.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Create User</button>
        </form>
    <?php endif; ?>
</body>
</html>
