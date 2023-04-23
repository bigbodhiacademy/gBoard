<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Score</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>
        .stars {
            font-size: 24px;
            color: gray;
            display: inline-block;
            position: relative;
            padding: 0;
            cursor: pointer;
        }

        .stars:before {
            content: '\f006 \f006 \f006 \f006 \f006';
            font-family: FontAwesome;
        }

        .stars>input {
            display: none;
        }

        .stars:hover:before,
        .stars:hover ~ .stars:before,
        .stars input:checked ~ .stars:before {
            color: gold;
            text-shadow: 0 0 5px rgba(255, 215, 0, 0.8);
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
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
            <?php
            for ($i = 1; $i <= 4; $i++) {
                echo '<div class="form-group">';
                echo "<label for='score{$i}'>Category {$i} Score:</label>";
                echo '<div class="stars">';
                for ($j = 5; $j >= 1; $j--) {
                    echo "<input type='radio' name='score{$i}' value='{$j}' id='score{$i}-{$j}'>";
                    echo "<label class='star' for='score{$i}-{$j}'></label>";
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add Score">
                <input type="submit" class="btn btn-success" value="Update Score" style="display:none">
                <input type="submit" class="btn btn-danger" value="Delete Score" style="display:none">
            </div>
        </form>
    </div>
    <script>
        // Check if a score already exists and show the Update and Delete buttons accordingly
        document.getElementById('student_id').addEventListener('change', function() {
            // Use AJAX to check if a score exists for the selected student
            // If yes, show the Update and Delete buttons
            // If not, hide the Update and Delete buttons
        });
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>

