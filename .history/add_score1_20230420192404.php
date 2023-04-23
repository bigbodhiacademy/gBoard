<?php include 'header.php'; ?>

<div class="container">
    <h2 class="text-center mt-5">Add/Edit/Delete Score</h2>

    <form action="functions.php" method="post" class="mt-5">
        <div class="form-group">
            <label for="student_id">Student:</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select a student</option>
                <?php foreach (getStudents() as $student): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="score1">Category 1 Score:</label>
            <input type="hidden" id="score1" name="score1" value="" required>
            <div class="stars">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <label for="score1">&#9733;</label>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Repeat the same code for categories 2, 3, and 4 -->

        <input type="hidden" name="action" value="add_score">
        <button type="submit" class="btn btn-primary">Add Score</button>
    </form>

    <!-- Add a delete button to remove a score -->
    <form action="functions.php" method="post" class="mt-3">
        <input type="hidden" name="action" value="delete_score">
        <input type="hidden" name="score_id" value="<!-- Add the score ID here -->">
        <button type="submit" class="btn btn-danger">Delete Score</button>
    </form>

    <!-- Add a form for updating scores -->
    <form action="functions.php" method="post" class="mt-3">
        <!-- Add inputs for updating the score (similar to the add_score form) -->
        <input type="hidden" name="action" value="update_score">
        <input type="hidden" name="score_id" value="<!-- Add the score ID here -->">
        <button type="submit" class="btn btn-warning">Update Score</button>
    </form>
</div>

<?php include 'footer.php'; ?>
