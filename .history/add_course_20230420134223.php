<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Course</title>
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
              <a class="nav-link" href="index.php">Add Student</a>
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
        <h1 class="text-center mt-5">Add Course</h1>
        <hr>
        
        <!-- Add course form -->
        <form method="POST" action="functions.php">
          <input type="hidden" name="action" value="add_course">
          <div class="form-group">
            <label for="course_name">Course Name:</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>
          </div>
          <div class="form-group">
            <label for="course_description">Course Description:</label>
            <textarea class="form-control" id="course_description" name="course_description" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Add Course</button>
        </form>
      </main>
    </div>
  </div>
</body>
</html>
