<?php
session_start();
require_once 'functions.php';

$username = $_POST['username'];
$password = $_POST['password'];

$user = authenticateUser($username, $password);

if ($user) {
    $_SESSION['user'] = $user;
    echo "login successful";
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
