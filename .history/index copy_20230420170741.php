<?php
include 'functions.php';
include 'header.php';
?>

      <!-- Main Content -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="text-center mt-5">Gamified Website</h1>
        <hr>
        
        <!-- Add student form -->
        <h3>Add Student</h3>
        <form method="POST" action="functions.php">
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
              include 'functions.php';
              $courses = getCourses();
              foreach ($courses as $course) {
                echo "<option value='" . $course['id'] . "'>" . $course['name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="school_id">School:</label>
            <select class="form-control" name="school_id" id="school_id" required>
                <!-- Replace the options below with the actual schools from your database -->
                <option value="1">School 1</option>
                <option value="2">School 2</option>
                <option value="3">School 3</option>
            </select>
        </div>

          <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
      </main>

      
<?php
include 'footer.php';
?>