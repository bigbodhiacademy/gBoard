<?php require_once 'functions.php'; ?>
<?php include 'header.php'; ?>

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
    updateLeaderboard();
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

<?php include 'footer.php'; ?>
