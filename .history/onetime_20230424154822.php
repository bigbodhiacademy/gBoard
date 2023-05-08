<?php
require_once 'functions.php';
$username = 'sam';
$email = 'svd2305@gmail.com.com';
$password = password_hash('hotsummer', PASSWORD_DEFAULT);//hotsummer
$user_role = 'super_user';

createSuperUser($username, $email, $password, $user_role);


?>