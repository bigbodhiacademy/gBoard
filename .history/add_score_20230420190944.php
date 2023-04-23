<?php include 'header.php'; ?>
<?php require_once 'functions.php'; ?>

<h2>Add Score</h2>

<form action="functions.php" method="post">
  <input type="hidden" name="action" value="add_score">
  <div>
    <label for="student_id">Student:</label>
    <select name="student_id" id="student_id">
      <?php
      $students = getStudents();
      foreach ($students as $student) {
        echo '<option value="' . $student['id'] . '">' . $student['name'] . '</option>';
      }
      ?>
    </select>
  </div>
  <div>
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
  </div>
  <div>
  <div>
  <label for="score1">Category 1 Score:</label>
  <div class="stars">
    <?php for ($i = 5; $i >= 1; $i--): ?>
      <input type="radio" id="score1-<?php echo $i; ?>" name="score1" value="<?php echo $i; ?>" required>
      <label for="score1-<?php echo $i; ?>">&#9733;</label>
    <?php endfor; ?>
  </div>
</div>

  <button type="submit">Add Score</button>
</form>

<?php include 'footer.php'; ?>
