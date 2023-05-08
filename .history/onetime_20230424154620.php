<?php
$username = 'super_user';
$email = 'super_user@example.com';
$password = password_hash('your_super_user_password', PASSWORD_DEFAULT);
$user_role = 'super_user';

createSuperUser($username, $email, $password, $user_role);


?>