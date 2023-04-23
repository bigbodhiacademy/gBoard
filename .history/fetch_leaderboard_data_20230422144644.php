<?php
require_once 'functions.php';

$interval = isset($_POST['interval']) ? $_POST['interval'] : 'all';
$month = isset($_POST['month']) ? $_POST['month'] : null;
$year = isset($_POST['year']) ? $_POST['year'] : null;
$categories = isset($_POST['categories']) ? json_decode($_POST['categories'], true) : [];


if ($interval === 'monthly' && $month !== null && $year !== null) {
  $month = intval(substr($month, 5));
  $year = intval(substr($year, 0, 4));
  $leaderboardData = getMonthlyLeaderboardData($month, $year);
} else if ($interval === 'yearly' && $year !== null) {
  $year = intval($year);
  $leaderboardData = getYearlyLeaderboardData($year);
} else {
  //$leaderboardData = getLeaderboardData();
  $leaderboardData = getLeaderboardData($categories);
}

$data = [];

while ($row = $leaderboardData->fetch_assoc()) {
  $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
