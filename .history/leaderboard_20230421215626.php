<?php require_once 'functions.php'; ?>
<?php
    $limit = 10; // Number of rows to display per page
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $limit;
    $totalRows = getLeaderboardRowCount();
    $totalPages = ceil($totalRows / $limit);
?>
<?php include 'header.php'; ?>


<div class="container mt-5">
    <h2 class="text-center">Leaderboard</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Total Points</th>
                <th>Average Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $leaderboardData = getLeaderboardData($offset, $limit);
                while ($row = $leaderboardData->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['total_points']}</td>";
                    echo "<td>{$row['average_score']}</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

<?php include 'footer.php'; ?>
