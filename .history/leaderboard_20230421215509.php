<?php require_once 'functions.php'; ?>
<?php
    $limit = 10; // Number of rows to display per page
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $limit;
    $totalRows = getLeaderboardRowCount();
    $totalPages = ceil($totalRows / $limit);
?>
<?php include 'header.php'; ?>


<div class="container">
<h2 class="text-center mt-5">Leaderboard</h2>

<table class="table">
  <thead>
    <tr>
      <th>Rank</th>
      <th>Student</th>
      <th>Total Points</th>
      <th>Average Score</th>
    </tr>
  </thead>
  <tbody>
    <?php
    //updateLeaderboard();
    $leaderboardData = getLeaderboardData();
    $rank = 0;

    while ($row = $leaderboardData->fetch_assoc()) {
      $rank++;
      echo "<tr>";
      echo "<td>{$rank}</td>";
      echo "<td>{$row['name']}</td>";
      echo "<td>{$row['total_points']}</td>";
      echo "<td>{$row['average_score']}</td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>
</div>

<?php include 'footer.php'; ?>
