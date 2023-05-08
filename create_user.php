<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'super_user') {
    header('Location: login.php');
    exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

createUser($username, $email, $password);
header('Location: dashboard.php');
?>
