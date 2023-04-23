<?php
require_once 'functions.php';

$interval = isset($_POST['interval']) ? $_POST['interval'] : 'all';
$month = isset($_POST['month']) ? $_POST['month'] : null;
$year = isset($_POST['year']) ? $_POST['year'] : null;
$categories = isset($_POST['categories']) ? json_decode($_POST['categories'], true) : [];

if ($interval === 'monthly' && $month !== null && $year !== null) {
  $month = intval(substr($month, 5));
  $year = intval(substr($year, 0, 4));
  $leaderboardData = getMonthlyLeaderboardData($month, $year, $categories);
} else if ($interval === 'yearly' && $year !== null) {
  $year = intval($year);
  $leaderboardData = getYearlyLeaderboardData($year, $categories);
} else {
  $leaderboardData = getLeaderboardData(0, 10, $categories);
}

$data = [];

while ($row = $leaderboardData->fetch_assoc()) {
  $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
