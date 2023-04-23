<?php require_once 'functions.php'; ?>

<?php include 'header.php'; ?>
<div class="container mt-5">
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
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </main>
    </div>
  
    <?php include 'footer.php'; ?>