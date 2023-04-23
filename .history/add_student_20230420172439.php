<?php require_once 'functions.php'; ?>

<?php include 'header.php'; ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="text-center mt-5">Gamified Website</h1>
        <hr>
<div class="container mt-5">
    <h2 class="text-center">Add Student</h2>
    <form action="functions.php" method="post">
        <input type="hidden" name="action" value="add_student">
        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" class="form-control" name="student_name" id="student_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="course_id">Course:</label>
            <select class="form-control" name="course_id" id="course_id" required>
                <?php
                $courses = getCourses();
                foreach ($courses as $course) {
                    echo '<option value="' . $course['id'] . '">' . $course['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="school_id">School:</label>
            <select class="form-control" name="school_id" id="school_id" required>
                <?php
                $schools = getSchools();
                foreach ($schools as $school) {
                    echo '<option value="' . $school['id'] . '">' . $school['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
</div>
</main>

<?php include 'footer.php'; ?>
