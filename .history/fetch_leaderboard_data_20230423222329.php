<?php
require_once 'functions.php';

// Get the input data from the AJAX request
$interval = $_POST['interval'];
$month = $_POST['month'];
$year = $_POST['year'];
$offset = $_POST['offset'];
$limit = $_POST['limit'];

// Initialize an empty array for the result data
$data = array();

// Based on the interval, call the appropriate function to fetch the leaderboard data
if ($interval === 'monthly') {
    $result = getMonthlyLeaderboardData($month, $year, $offset, $limit);
} elseif ($interval === 'yearly') {
    $result = getYearlyLeaderboardData($year, $offset, $limit);
} else {
    // Handle the "all-time" case, if needed
    $result = getAllTimeLeaderboardData($offset, $limit);
}

// If the result object is not empty, fetch the data as an associative array
if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
}

// Set the content type header and return the JSON-encoded data
header('Content-Type: application/json');
echo json_encode($data);
?>
