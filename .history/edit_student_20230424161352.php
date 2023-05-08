<?php require_once 'functions.php'; ?>

<?php include 'header_restricted.php'; ?>


<?php
$student_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($student_id === null) {
    echo 'Error: Student not found.';
    exit;
}

$student = getStudentById($student_id);

if (!$student) {
    echo 'Error: Student not found.';
    exit;
}
?>

<div class="container mt-5">
    <h2 class="text-center">Edit Student</h2>
    <form action="functions.php" method="post">
        <input type="hidden" name="action" value="edit_student">
        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" class="form-control" name="student_name" id="student_name" value="<?php echo $student['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $student['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="course_id">Course:</label>
            <select class="form-control" name="course_id" id="course_id" required>
                <?php
                $courses = getCourses();
                foreach ($courses as $course) {
                    $selected = $student['course_id'] == $course['id'] ? 'selected' : '';
                    echo '<option value="' . $course['id'] . '" ' . $selected . '>' . $course['name'] . '</option>';
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
                    $selected = $student['school_id'] == $school['id'] ? 'selected' : '';
                    echo '<option value="' . $school['id'] . '" ' . $selected . '>' . $school['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php include 'footer.php'; ?>
