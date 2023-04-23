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
    <form action="functions.php" method="post">
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
                for ($j = 1; $j <= 5; $j++) {
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
            <input type="submit" class="btn btn-success" value="Update Score" style="display:none">
            <input type="submit" class="btn btn-danger" value="Delete Score" style="display:none">
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
