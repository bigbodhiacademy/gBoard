<?php
include 'functions.php';
include 'header.php';
?>


<div class="container">
    <h2 class="text-center mt-5">Add Course</h2>
    <form action="functions.php" method="post">
        <input type="hidden" name="action" value="add_course">
        <div class="form-group">
            <label for="course_name">Course Name:</label>
            <input type="text" class="form-control" name="course_name" id="course_name" required>
        </div>
        <div class="form-group">
            <label for="course_description">Course Description:</label>
            <textarea class="form-control" name="course_description" id="course_description" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>
<div class="container">
    <h2 class="text-center mt-5">Add School</h2>
    <form action="functions.php" method="post">
        <input type="hidden" name="action" value="add_school">
        <div class="form-group">
            <label for="school_name">School Name:</label>
            <input type="text" class="form-control" name="school_name" id="school_name" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" name="location" id="location" required>
        </div>
        <button type="submit" class="btn btn-primary">Add School</button>
    </form>
</div>




<?php
include 'footer.php';
?>