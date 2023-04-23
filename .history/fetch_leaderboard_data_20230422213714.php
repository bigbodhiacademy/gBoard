<?php
// fetch_leaderboard_data.php
require_once 'functions.php';

// Get the input data from the AJAX request
$interval = $_POST['interval'];
$month = $_POST['month'];
$year = $_POST['year'];
$categories = json_decode($_POST['categories'], true);

// Create a WHERE clause based on the categories
$category_conditions = [];
foreach ($categories as $category) {
  $category_conditions[] = "s.`$category` = 1";
}
$where_clause = implode(" OR ", $category_conditions);

// Create a query based on the interval and categories
if ($interval === 'monthly') {
  $query = "SELECT l.* FROM leaderboard l JOIN scores s ON l.student_id = s.student_id WHERE MONTH(s.`date`) = $month AND YEAR(s.`date`) = $year AND ($where_clause)";
} elseif ($interval === 'yearly') {
  $query = "SELECT l.* FROM leaderboard l JOIN scores s ON l.student_id = s.student_id WHERE YEAR(s.`date`) = $year AND ($where_clause)";
} else {
  $query = "SELECT l.* FROM leaderboard l JOIN scores s ON l.student_id = s.student_id WHERE ($where_clause)";
}

// Execute the query and return the results as JSON
$result = $conn->query($query);
// Check if the result is false, which indicates an error
if (!$result) {
  // Print the MySQLi error message
  die("Query error: " . $conn->error);
}
$data = $result->fetch_all(MYSQLI_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);
?>
