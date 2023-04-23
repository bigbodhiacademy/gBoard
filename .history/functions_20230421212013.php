<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['action'])) {
      $action = $_POST['action'];
      
      switch ($action) {
        case 'add_student':
          $name = $_POST['student_name'];
          $email = $_POST['email'];
          $course_id = $_POST['course_id'];
          $school_id = $_POST['school_id'];
          addStudent($name, $email, $course_id, $school_id);
          header('Location: add_student.php?message=Student+Added');
          exit();

        case 'add_course':
          $course_name = $_POST['course_name'];
          $course_description = $_POST['course_description'];
          addCourse($course_name, $course_description);
          header('Location: add_school_course.php?message=Course+Added');
          exit();

        case 'add_school':
          $school_name = $_POST['school_name'];
          $location = $_POST['location'];
          addSchool($school_name, $location);
          header('Location: add_school_course.php?message=School+Added');
          exit();

        case 'edit_student':
          $student_id = $_POST['student_id'];
          $name = $_POST['student_name'];
          $email = $_POST['email'];
          $course_id = $_POST['course_id'];
          $school_id = $_POST['school_id'];
          editStudent($student_id, $name, $email, $course_id, $school_id);
          header('Location: list_students.php');
          exit();

        case 'add_score':
          $student_id = $_POST['student_id'];
          $date = $_POST['date'];
          $category1 = $_POST['score1'];
          $category2 = $_POST['score2'];
          $category3 = $_POST['score3'];
          $category4 = $_POST['score4'];
          addScore($student_id, $date, $category1, $category2, $category3, $category4);
          header('Location: add_score.php');
          exit();

        case 'check_score_exists':
          if (isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
            $date = $_POST['date'];
            $scoreExists = checkScoreExists($student_id, $date);
            echo json_encode($scoreExists);
            exit();
          }

        case 'get_student_scores':
          if (isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
            $limit = $_POST['limit'];
            $offset = $_POST['offset'];
            $scores = getStudentScores($student_id, $limit, $offset);
            $scoresArray = array();
            while ($score = $scores->fetch_assoc()) {
                $scoresArray[] = $score;
            }
            echo json_encode($scoresArray);
          }
        
        case 'delete_score':
          if (isset($_POST['score_id'])) {
            $score_id = $_POST['score_id'];
            $deletedRows = deleteScore($score_id);
            if ($deletedRows > 0) {
              echo 'Score deleted successfully';
            } else {
              echo 'Error deleting score';
            }
          }
          exit();

        case 'update_score':
          if (isset($_POST['score_id']) && isset($_POST['category1']) && isset($_POST['category2']) && isset($_POST['category3']) && isset($_POST['category4'])) {
              $score_id = $_POST['score_id'];
              $category1 = $_POST['category1'];
              $category2 = $_POST['category2'];
              $category3 = $_POST['category3'];
              $category4 = $_POST['category4'];
  
              $affectedRows = updateScore($score_id, $category1, $category2, $category3, $category4);
              if ($affectedRows > 0) {
                  echo 'Score updated successfully';
              } else {
                  echo 'Error updating score';
              }
          }
          exit();
      }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action == 'delete_student'){
      $student_id = $_GET['id'];
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

function getAllStudents1() {
  global $conn;
  $sql = "SELECT students.*, courses.name as course_name, schools.name as school_name FROM students INNER JOIN courses ON students.course_id = courses.id INNER JOIN schools ON students.school_id = schools.id";
  $result = mysqli_query($conn, $sql);

  $students = array();
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $students[] = $row;
      }
  }

  return $students;
}

function getAllStudents() {
  global $conn;
  $sql = "SELECT * FROM students";
  $result = $conn->query($sql);
  return $result;
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

function addScore($student_id, $date, $category1, $category2, $category3, $category4) {
  global $conn;
  $query = "INSERT INTO scores (student_id, date, category1, category2, category3, category4) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'isiiii', $student_id, $date, $category1, $category2, $category3, $category4);
  mysqli_stmt_execute($stmt);
}

function checkScoreExists($student_id, $date) {
  global $conn;

  $stmt = $conn->prepare("SELECT COUNT(*) as count FROM scores WHERE student_id = ? AND date = ?");
  $stmt->bind_param("is", $student_id, $date);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  return $row['count'] > 0;
}


function getStudentScores($student_id) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM scores WHERE student_id=? ORDER BY date DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("iii", $student_id, $limit, $offset);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
}


function updateScore($scoreId, $category1, $category2, $category3, $category4) {
  global $conn;

  $stmt = $conn->prepare("UPDATE scores SET category1=?, category2=?, category3=?, category4=? WHERE id=?");
  $stmt->bind_param("iiiii", $category1, $category2, $category3, $category4, $scoreId);

  if ($stmt->execute()) {
      return true;
  } else {
    error_log("Update Score Error: " . $stmt->error);
      return false;
  }
}


function deleteScore($score_id) {
  global $conn;
  $sql = "DELETE FROM scores WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $score_id);
  $stmt->execute();
  return $stmt->affected_rows;
}




?>
