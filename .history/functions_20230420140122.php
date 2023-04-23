<?php
include 'db_connection.php';

function getConnection() {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "leaderboard4";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
      $action = $_POST['action'];
      if ($action == 'add_student') {
          $name = $_POST['name'];
          $email = $_POST['email'];
          $course_id = $_POST['course_id'];
          addStudent($name, $email, $course_id);
          //header('Location: index.php?message=Student+Added');
          //exit();
      } elseif ($action == 'add_course') {
          $course_name = $_POST['course_name'];
          $course_description = $_POST['course_description'];
          addCourse($course_name, $course_description);
          header('Location: add_course.php?message=Course+Added');
          exit();
      }
  }
}


function addCourse($course_name, $course_description) {
  $conn = getConnection();
  $date_added = date('Y-m-d');
  $sql = "INSERT INTO courses (name, description, date_added) VALUES (?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $course_name, $course_description, $date_added);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function getStudentsWithCourseName() {
  $students = array();
  $conn = getConnection();
  
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

function addStudent($name, $email, $course_id) {
  global $conn;
  echo "addStudent($name, $email, $course_id";
  $stmt = $conn->prepare("INSERT INTO students (name, email, course_id) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $name, $email, $course_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function editStudent($id, $name, $email, $course_id) {
  global $conn;

  $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course_id = ? WHERE id = ?");
  $stmt->bind_param("ssii", $name, $email, $course_id, $id);

  return $stmt->execute();
}

function deleteStudent($id) {
  global $conn;

  $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
  $stmt->bind_param("i", $id);

  return $stmt->execute();
}


function getStudents() {
  global $conn;

  $result = $conn->query("SELECT * FROM students");
  return $result->fetch_all(MYSQLI_ASSOC);
}

function getCourses() {
  global $conn;

  $result = $conn->query("SELECT * FROM courses");
  return $result->fetch_all(MYSQLI_ASSOC);
}




?>
