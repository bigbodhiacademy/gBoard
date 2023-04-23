<?php
// fetch_leaderboard_data.php

// Get the input data from the AJAX request
$interval = $_POST['interval'];
$month = $_POST['month'];
$year = $_POST['year'];
$categories = json_decode($_POST['categories'], true);

// Create a WHERE clause based on the categories
$category_conditions = [];
foreach ($categories as $category) {
  $category_conditions[] = "`$category` = 1";
}
$where_clause = implode(" OR ", $category_conditions);

// Create a query based on the interval and categories
if ($interval === 'monthly') {
  $query = "SELECT * FROM leaderboard WHERE MONTH(`date`) = $month AND YEAR(`date`) = $year AND ($where_clause)";
} elseif ($interval === 'yearly') {
  $query = "SELECT * FROM leaderboard WHERE YEAR(`date`) = $year AND ($where_clause)";
} else {
  $query = "SELECT * FROM leaderboard WHERE ($where_clause)";
}

// Execute the query and return the results as JSON
$result = $conn->query($query);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
?>
