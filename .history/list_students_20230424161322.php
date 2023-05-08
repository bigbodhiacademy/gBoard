<?php include 'header_restricted.php'; ?>
<?php require_once("functions.php"); ?>

<div class="container">
    <h2 class="text-center">Students List</h2>
    <?php
    $students = getStudents();
    if ($students) {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>School</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($students as $student) {
                    $course = getCourseById($student['course_id']);
                    $school = getSchoolById($student['school_id']);
                ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $course['name']; ?></td>
                        <td><?php echo $school['name']; ?></td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
    ?>
        <p class="text-center">No students found.</p>
    <?php
    }
    ?>
</div>

<?php require_once("footer.php"); ?>
