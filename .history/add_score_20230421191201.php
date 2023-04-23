<?php require_once 'functions.php'; ?>
<?php include 'header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<style>
    .categories-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .category {
        width: 20%;
    }
    .stars {
        display: inline-block;
    }
    .stars input[type="radio"] {
        display: none;
    }
    .stars label.star {
        display: inline-block;
        cursor: pointer;
        font-size: 30px;
        margin: 0;
        padding: 0;
        color: grey;
    }
    .stars label.star:hover,
    .stars label.star:hover ~ label.star,
    .stars input[type="radio"]:checked ~ label.star {
        color: gold;
    }
</style>

<div class="container">
    <h2 class="text-center mt-5">Add Score</h2>
    <form action="functions.php" method="post" id="score-form">
        <input type="hidden" name="action" value="add_score">
        <div class="form-group">
            <label for="student_id">Student:</label>
            <select class="form-control" name="student_id" id="student_id" required>
                <option value="">Select a student</option>
                <?php
                $students = getAllStudents();
                while ($student = $students->fetch_assoc()) {
                    echo "<option value='{$student['id']}'>{$student['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" name="date" id="date" required>
        </div>
        <div class="categories-container">
            <?php
            for ($i = 1; $i <= 4; $i++) {
                echo '<div class="category">';
                echo "<label for='score{$i}'>Category {$i} Score:</label>";
                echo '<div class="stars">';
                for ($j = 5; $j >= 1; $j--) {
                    echo "<input type='radio' name='score{$i}' value='{$j}' id='score{$i}-{$j}'>";
                    echo "<label class='star' for='score{$i}-{$j}'><i class='fas fa-star'></i></label>";
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Score">
        </div>
    </form>

    <div class="container mt-5">
        <h3 class="text-center">Student Scores</h3>
        <table class="table" id="scores-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category 1</th>
                    <th>Category 2</th>
                    <th>Category 3</th>
                    <th>Category 4</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
    function updateScoresTable(studentId) {
        const tableBody = document.querySelector('#scores-table tbody');
        tableBody.innerHTML = '';

        if (studentId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'functions.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const scores = JSON.parse(this.responseText);
                    scores.forEach(score => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${score.date}</td>
                            <td>${score.category1}</td>
                            <td>${score.category2}</td>
                            <td>${score.category3}</td>
                            <td>${score.category4}</td>
                            <td>
                                <button class="btn btn-success btn-sm update-score-btn" data-score-id="${score.id}">Update</button>
                                <button class="btn btn-danger btn-sm delete-score-btn" data-score-id="${score.id}">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                    addScoreRowEventListeners();
                }
            };
            xhr.send('action=get_student_scores&student_id=' + studentId);
        }
    }

    document.getElementById('student_id').addEventListener('change', function() {
        const studentId = this.value;
        updateScoresTable(studentId);
    });

    function addScoreRowEventListeners() {
        const updateButtons = document.querySelectorAll('.update-score-btn');
        const deleteButtons = document.querySelectorAll('.delete-score-btn');

        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const scoreId = this.getAttribute('data-score-id');
                // Get the row containing the score data
                const scoreRow = this.parentElement.parentElement;
                // Get the score data for each category
                const category1 = scoreRow.children[1].innerText;
                const category2 = scoreRow.children[2].innerText;
                const category3 = scoreRow.children[3].innerText;
                const category4 = scoreRow.children[4].innerText;

                // Call the updateScore function to send the data to the server
                updateScore(scoreId, category1, category2, category3, category4);
            });

        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const scoreId = this.getAttribute('data-score-id');
                // Delete the score here
                deleteScore(scoreId);
            });
        });
    }

    function deleteScore(scoreId) {
        if (confirm('Are you sure you want to delete this score?')) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'functions.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    alert('Score deleted successfully');
                    updateScoresTable(document.getElementById('student_id').value);
                } else {
                    alert('Error deleting score');
                }
            };
            xhr.send('action=delete_score&score_id=' + scoreId);
        }
    }

    document.getElementById('score-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const studentId = formData.get('student_id');
        const date = formData.get('date');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'functions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                const scoreExists = JSON.parse(this.responseText);
                if (scoreExists) {
                    alert('Score already exists for this student on the selected date. Duplicate entry is ignored.');
                } else {
                    document.getElementById('score-form').submit();
                }
            }
        };
        xhr.send('action=check_score_exists&student_id=' + studentId + '&date=' + date);
    });
</script>

</div>

<?php include 'footer.php'; ?>
