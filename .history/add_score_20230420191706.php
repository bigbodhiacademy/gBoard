<?php include 'header.php'; ?>

<h2>Add/Edit/Delete Score</h2>

<form action="functions.php" method="post">
    <div>
        <label for="student_id">Student:</label>
        <select name="student_id" id="student_id" required>
            <option value="">Select a student</option>
            <?php foreach (getStudents() as $student): ?>
                <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
    </div>

    <div>
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
    <input type="submit" value="Add Score">
</form>

<!-- Add a delete button to remove a score -->
<form action="functions.php" method="post">
    <input type="hidden" name="action" value="delete_score">
    <input type="hidden" name="score_id" value="<!-- Add the score ID here -->">
    <input type="submit" value="Delete Score">
</form>

<!-- Add a form for updating scores -->
<form action="functions.php" method="post">
    <!-- Add inputs for updating the score (similar to the add_score form) -->
    <input type="hidden" name="action" value="update_score">
    <input type="hidden" name="score_id" value="<!-- Add the score ID here -->">
    <input type="submit" value="Update Score">
</form>

<?php include 'footer.php'; ?>
