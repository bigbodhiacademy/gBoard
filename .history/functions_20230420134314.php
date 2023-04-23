<?php
include 'db_connection.php';

function addStudent($name, $email, $course_id) {
  global $conn;

  $stmt = $conn->prepare("INSERT INTO students (name, email, course_id) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $name, $email, $course_id);

  return $stmt->execute();
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

function addCourse($name, $description, $date_added) {
  global $conn;

  $stmt = $conn->prepare("INSERT INTO courses (name, description, date_added) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $description, $date_added);

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

?>
