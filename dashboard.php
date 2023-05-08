<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$pageTitle = 'Dashboard';
include 'header.php';
?>

<div class="container mt-5">
    <h2>Welcome, <?php echo $user['username']; ?></h2>

    <?php if ($user['user_role'] === 'super_user'): ?>
        <h3>Create a new user</h3>
        <form action="create_user.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
