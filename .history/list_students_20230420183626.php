<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Students</title>
  <!-- Add Bootstrap and other necessary files here -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Side Navbar -->
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="add_student.php">Add Student</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add_course.php">Add Course</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="list_students.php">List Students</a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="text-center mt-5">List Students</h1>
        <hr>

        <h2>Students</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Course</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'functions.php';
            $students = getStudentsWithCourseName();
            foreach ($students as $student) {
              echo '<tr>';
              echo '<td>' . $student['name'] . '</td>';
              echo '<td>' . $student['email'] . '</td>';
              echo '<td>' . $student['course_name'] . '</td>';
              echo '<td><a href="edit_student.php?id=' . $student['id'] . '">Edit</a></td>';
              echo '<td><a href="functions.php?action=delete_student&id=' . $student['id'] . '">Delete</a></td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </main>
    </div>
  </div>
</body>
</html>
