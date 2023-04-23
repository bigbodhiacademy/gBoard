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

    // ...
});

function addScoreRowEventListeners() {
    const updateButtons = document.querySelectorAll('.update-score-btn');
    const deleteButtons = document.querySelectorAll('.delete-score-btn');

    updateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const scoreId = this.getAttribute('data-score-id');
            // Update the score here
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const scoreId = this.getAttribute('data-score-id');
            // Delete the score here
        });
    });
}
document.getElementById('update-score-btn').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('score-form'));
    formData.set('action', 'update_score');

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'functions.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            alert('Score updated successfully');
            updateScoresTable(document.getElementById('student_id').value);
        } else {
            alert('Error updating score');
        }
    };
    xhr.send(formData);
});

document.getElementById('delete-score-btn').addEventListener('click', function() {
    if (confirm('Are you sure you want to delete this score?')) {
        const formData = new FormData();
        formData.set('action', 'delete_score');
        formData.set('score_id', document.getElementById('score_id').value);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'functions.php', true);
        xhr.onload = function() {
            if (this.status === 200) {
                alert('Score deleted successfully');
                updateScoresTable(document.getElementById('student_id').value);
            } else {
                alert('Error deleting score');
            }
        };
        xhr.send(formData);
    }
});




    document.getElementById('student_id').addEventListener('change', function() {
        const studentId = this.value;

        if (studentId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'functions.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const scoreExists = JSON.parse(this.responseText);
                    if (scoreExists) {
                        document.querySelector('.btn.btn-success').style.display = 'inline-block';
                        document.querySelector('.btn.btn-danger').style.display = 'inline-block';
                    } else {
                        document.querySelector('.btn.btn-success').style.display = 'none';
                        document.querySelector('.btn.btn-danger').style.display = 'none';
                    }
                }
            };
            xhr.send('action=check_score_exists&student_id=' + studentId);
        } else {
            document.querySelector('.btn.btn-success').style.display = 'none';
            document.querySelector('.btn.btn-danger').style.display = 'none';
        }
    });

  


</script>

</div>

<?php include 'footer.php'; ?>
