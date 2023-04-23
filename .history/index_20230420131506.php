<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gamified Website</title>
  <!-- Add Bootstrap and other necessary files here -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
  <div class="container">
    <h1 class="text-center mt-5">Gamified Website</h1>
    <hr>
    
    <!-- Add student form -->
    <h3>Add Student</h3>
    <form method="POST">
      <input type="hidden" name="action" value="add_student">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="course_id">Course:</label>
        <select class="form-control" id="course_id" name="course_id" required>
          <option value="">--Select Course--</option>
          <?php
          $courses = getCourses();
          foreach ($courses as $course) {
            echo "<option value='" . $course['id'] . "'>" . $course['name'] . "</option>";
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
<!-- Add your other forms for editing and deleting students and courses here -->

    <h2 class="text-center mt-5">Students List</h2>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Course ID</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'functions.php';
        $students = getStudents();
        foreach ($students as $student) {
          echo "<tr>";
          echo "<td>" . $student['id'] . "</td>";
          echo "<td>" . $student['name'] . "</td>";
          echo "<td>" . $student['email'] . "</td>";
          echo "<td>" . $student['course_id'] . "</td>";
          echo "<td>";
          echo "<a href='edit_student.php?id=" . $student['id'] . "' class='btn btn-sm btn-primary'>Edit</a> ";
          echo "<a href='delete_student.php?id=" . $student['id'] . "' class='btn btn-sm btn-danger'>Delete</a>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
