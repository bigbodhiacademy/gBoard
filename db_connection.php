<?php
$servername = "localhost"; // Replace with your MySQL server address if it's not "localhost"
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "leaderboard4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
