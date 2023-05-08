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

<form id="leaderboardFilterForm">

<select name="interval" id="leaderboardInterval">
  <option value="all">All Time</option>
  <option value="monthly">Monthly</option>
  <option value="yearly">Yearly</option>
</select>
<select name="month" id="leaderboardMonth" style="display:none;">
  <option value="01">January</option>
  <option value="02">February</option>
  <option value="03">March</option>
  <option value="04">April</option>
  <option value="05">May</option>
  <option value="06">June</option>
  <option value="07">July</option>
  <option value="08">August</option>
  <option value="09">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
</select>
<select name="year" id="leaderboardYear" style="display:none;">
  <option value="2023">2023</option>
  <option value="2022">2022</option>
  <option value="2021">2021</option>
  <!-- Add more years as needed -->
</select>
<button type="submit">Apply Filters</button>
</form>


   
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="leaderboardTable">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Student Name</th>
                <th>Total Points</th>
                <!--th>Average Score</th-->
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1;
            // Get the selected categories from the form submission
            

            $leaderboardData = getLeaderboardData($offset, $limit);

            while ($row = $leaderboardData->fetch_assoc()):
            ?>
                <tr>
                    <th scope="row"><?php echo $rank; ?></th>
                    <td><?php echo $row['name']; ?> <?php //echo getBadgeForRank($rank); ?></td>
                    <td><?php echo $row['total_points']; ?></td>
                    
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
  $totalScoreData = []; // Add this line to store total scores

  foreach ($studentsData as $studentData) {
    $labels[] = $studentData['name'];
    $category1Data[] = $studentData['category1_avg'];
    $category2Data[] = $studentData['category2_avg'];
    $category3Data[] = $studentData['category3_avg'];
    $category4Data[] = $studentData['category4_avg'];
    $totalScoreData[] = $studentData['category1_avg'] + $studentData['category2_avg'] + $studentData['category3_avg'] + $studentData['category4_avg']; // Calculate and store total score
  }
?>


<script>
  document.addEventListener('DOMContentLoaded', function() {
  const intervalSelect = document.getElementById('leaderboardInterval');
  const monthInput = document.getElementById('leaderboardMonth');
  const yearInput = document.getElementById('leaderboardYear');

  intervalSelect.addEventListener('change', function() {
    if (this.value === 'monthly') {
      monthInput.style.display = 'inline';
      yearInput.style.display = 'none';
    } else if (this.value === 'yearly') {
      monthInput.style.display = 'none';
      yearInput.style.display = 'inline';
    } else {
      monthInput.style.display = 'none';
      yearInput.style.display = 'none';
    }
  });
});


  createStudentScoresChart(
    <?php echo json_encode($labels); ?>,
    <?php echo json_encode($category1Data); ?>,
    <?php echo json_encode($category2Data); ?>,
    <?php echo json_encode($category3Data); ?>,
    <?php echo json_encode($category4Data); ?>,
    <?php echo json_encode($totalScoreData); ?> // Pass total score data
  );

  //createStudentScoresChart(labels, category1Data, category2Data, category3Data, category4Data);

  function createStudentScoresChart(labels, category1Data, category2Data, category3Data, category4Data, totalScoreData) {
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
        },
        {
          label: 'Total Score',
          data: totalScoreData,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
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

document.getElementById('leaderboardFilterForm').addEventListener('submit', function (event) {
  event.preventDefault();

  const interval = document.getElementById('leaderboardInterval').value;
  const month = document.getElementById('leaderboardMonth').value;
  const year = document.getElementById('leaderboardYear').value;
  
  // Make an AJAX request to fetch the leaderboard data based on the selected interval and categories
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      console.log("Server response:", this.responseText);
      const leaderboardData = JSON.parse(this.responseText);
      updateLeaderboardTable(leaderboardData);
    }
  };

  const offset = 0; // Or any other value for pagination
  const limit = 10; // Or any other value for the number of rows per page


  xhr.open("POST", "fetch_leaderboard_data.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`interval=${interval}&month=${month}&year=${year}&offset=${offset}&limit=${limit}`);

});


function updateLeaderboardTable(leaderboardData) {
  const tableBody = document.querySelector('#leaderboardTable tbody');
  tableBody.innerHTML = '';
  index=1;
  for (const row of leaderboardData) {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${index}</td>
      <td>${row.name}</td>
      <td>${row.total_points}</td>
      
    `;
    tableBody.appendChild(tr);
    index +=1;
  }
}



</script>





<?php include 'footer.php'; ?>
