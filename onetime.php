<?php
require_once 'functions.php';
$username = 'root';
$email = 'root@localhost';
$password = password_hash('password', PASSWORD_DEFAULT);
$user_role = 'super_user';

createSuperUser($username, $email, $password, $user_role);


?>
