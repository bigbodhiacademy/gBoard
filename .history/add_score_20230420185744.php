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
    <label for="category1">Category 1:</label>
    <input type="number" name="category1" id="category1" min="0" max="5" required>
  </div>
  <div>
    <label for="category2">Category 2:</label>
    <input type="number" name="category2" id="category2" min="0" max="5" required>
  </div>
  <div>
    <label for="category3">Category 3:</label>
    <input type="number" name="category3" id="category3" min="0" max="5" required>
  </div>
  <div>
    <label for="category4">Category 4:</label>
    <input type="number" name="category4" id="category4" min="0" max="5" required>
  </div>
  <button type="submit">Add Score</button>
</form>

<?php include 'footer.php'; ?>
