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

<!-- Add this above the leaderboard table -->
<form id="leaderboard-filter-form">
    <label>
        <input type="checkbox" name="categories[]" value="category1" checked> Category 1
    </label>
    <label>
        <input type="checkbox" name="categories[]" value="category2" checked> Category 2
    </label>
    <label>
        <input type="checkbox" name="categories[]" value="category3" checked> Category 3
    </label>
    <label>
        <input type="checkbox" name="categories[]" value="category4" checked> Category 4
    </label>
    <button type="submit">Apply Filters</button>
</form>


   
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Student Name</th>
                <th>Total Points</th>
                <th>Average Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1;
            // Get the selected categories from the form submission
            $categories = isset($_GET['categories']) ? $_GET['categories'] : [];

            $leaderboardData = getLeaderboardData($offset, $limit, $categories);

            while ($row = $leaderboardData->fetch_assoc()):
            ?>
                <tr>
                    <th scope="row"><?php echo $rank; ?></th>
                    <td><?php echo $row['name']; ?> <?php echo getBadgeForRank($rank); ?></td>
                    <td><?php echo $row['total_points']; ?></td>
                    <td><?php echo number_format($row['average_score'], 2); ?></td>
                </tr>
            <?php
            $rank++;
            endwhile;
            ?>
        </tbody>


    </table>

    <!-- Add pagination links -->
    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
    <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>
</div>

<!-- Add this line in the head section of your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Add this line in the body section of your HTML file -->
<canvas id="studentScoresChart"></canvas>
<?php
  // Fetch student names and their average scores in each category from your database
  $studentsData = getStudentNamesAndAverageScores();
  $labels = [];
  $category1Data = [];
  $category2Data = [];
  $category3Data = [];
  $category4Data = [];

  foreach ($studentsData as $studentData) {
    $labels[] = $studentData['name'];
    $category1Data[] = $studentData['category1_avg'];
    $category2Data[] = $studentData['category2_avg'];
    $category3Data[] = $studentData['category3_avg'];
    $category4Data[] = $studentData['category4_avg'];
  }
?>

<script>
  const labels = <?php echo json_encode($labels); ?>;
  const category1Data = <?php echo json_encode($category1Data); ?>;
  const category2Data = <?php echo json_encode($category2Data); ?>;
  const category3Data = <?php echo json_encode($category3Data); ?>;
  const category4Data = <?php echo json_encode($category4Data); ?>;

  createStudentScoresChart(labels, category1Data, category2Data, category3Data, category4Data);

  function createStudentScoresChart(labels, category1Data, category2Data, category3Data, category4Data) {
    const ctx = document.getElementById('studentScoresChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Category 1',
            data: category1Data,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          },
          {
            label: 'Category 2',
            data: category2Data,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
          },
          {
            label: 'Category 3',
            data: category3Data,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          },
          {
            label: 'Category 4',
            data: category4Data,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }
  
</script>





<?php include 'footer.php'; ?>
