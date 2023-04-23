<?php
include 'db_connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
      $action = $_POST['action'];
      if ($action == 'add_student') {
          $name = $_POST['student_name'];
          $email = $_POST['email'];
          $course_id = $_POST['course_id'];
          $school_id = $_POST['school_id'];
          //print_r($name,$school_id);
          addStudent($name, $email, $course_id, $school_id);
          header('Location: add_student.php?message=Student+Added');
          exit();
      } elseif ($action == 'add_course') {
          $course_name = $_POST['course_name'];
          $course_description = $_POST['course_description'];
          addCourse($course_name, $course_description);
          header('Location: add_school_course.php?message=Course+Added');
          exit();
      }elseif ($action == 'add_school') {
        $school_name = $_POST['school_name'];
        $location = $_POST['location'];
        addSchool($school_name, $location);
        header('Location: add_school_course.php?message=School+Added');
        exit();
      }elseif ($action == 'edit_student') {
        $student_id = $_POST['student_id'];
        $name = $_POST['student_name'];
        $email = $_POST['email'];
        $course_id = $_POST['course_id'];
        $school_id = $_POST['school_id'];

        editStudent($student_id, $name, $email, $course_id, $school_id);

        header('Location: list_students.php');
        exit();
      }elseif($action == 'add_score'){
        $student_id = $_POST['student_id'];
            $date = $_POST['date'];
            $category1 = $_POST['category1'];
            $category2 = $_POST['category2'];
            $category3 = $_POST['category3'];
            $category4 = $_POST['category4'];
            addScore($student_id, $date, $category1, $category2, $category3, $category4);
            header('Location: add_score.php');
            exit();
      }
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action == 'delete_student'){
      $student_id = $_GET['id'];
      print_r($student_id);
      deleteStudent($student_id);
      header('Location: list_students.php');
      exit();
    }
  }
}


function addSchool($school_name, $location) {
  $conn = getConnection();

  $stmt = $conn->prepare("INSERT INTO schools (name, location) VALUES (?, ?)");
  $stmt->bind_param("ss", $school_name, $location);

  $stmt->execute();

  $stmt->close();
  $conn->close();
}

function getSchools() {
  global $conn;
  $schools = array();
  
  $query = "SELECT * FROM schools";
  $result = mysqli_query($conn, $query);
  
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $schools[] = $row;
      }
  }
  
  return $schools;
}

function getSchoolById($school_id) {
  global $conn;
  $sql = "SELECT * FROM schools WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $school_id);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}



function addCourse($course_name, $course_description) {
  global $conn;
  $date_added = date('Y-m-d');
  $sql = "INSERT INTO courses (name, description, date_added) VALUES (?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $course_name, $course_description, $date_added);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
function getCourseById($course_id) {
  global $conn;
  $sql = "SELECT * FROM courses WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $course_id);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}


function editStudent($student_id, $name, $email, $course_id, $school_id) {
  global $conn;
  $query = "UPDATE students SET name = ?, email = ?, course_id = ?, school_id = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'ssiii', $name, $email, $course_id, $school_id, $student_id);
  mysqli_stmt_execute($stmt);
}

function getStudentsWithCourseName() {
  $students = array();
  global $conn;
  
  $sql = "SELECT students.id, students.name, students.email, courses.name as course_name
          FROM students
          INNER JOIN courses ON students.course_id = courses.id";
  
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $students[] = $row;
      }
  }
  $conn->close();
  
  return $students;
}

function getStudentById($student_id) {
  global $conn;
  $query = "SELECT * FROM students WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $student_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}


function addStudent($name, $email, $course_id, $school_id) {
  global $conn;
  //echo "add student";
  //print_r($name,$course_id);
  $stmt = $conn->prepare("INSERT INTO students (name, email, course_id, school_id) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssii", $name, $email, $course_id, $school_id);

  $stmt->execute();

  $stmt->close();
  $conn->close();
}


/*function editStudent($id, $name, $email, $course_id) {
  global $conn;

  $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course_id = ? WHERE id = ?");
  $stmt->bind_param("ssii", $name, $email, $course_id, $id);

  return $stmt->execute();
}*/

function deleteStudent1($id) {
  global $conn;

  $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
  $stmt->bind_param("i", $id);

  $stmt->execute();
  $stmt->close();
  $conn->close();
}
function deleteStudent($student_id) {
  global $conn;
  $query = "DELETE FROM students WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $student_id);
  mysqli_stmt_execute($stmt);
}


function getStudents() {
  global $conn;

  $result = $conn->query("SELECT * FROM students");
  echo $result->fetch_all(MYSQLI_ASSOC);
  return $result->fetch_all(MYSQLI_ASSOC);
}

function getCourses() {
  global $conn;

  $result = $conn->query("SELECT * FROM courses");
  return $result->fetch_all(MYSQLI_ASSOC);
}

function addScore($student_id, $date, $category1, $category2, $category3, $category4) {
  global $conn;
  $query = "INSERT INTO scores (student_id, date, category1, category2, category3, category4) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'isiiii', $student_id, $date, $category1, $category2, $category3, $category4);
  mysqli_stmt_execute($stmt);
}


?>
