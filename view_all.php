<?php
require_once __DIR__ . '/config/db.php';

// Fetch students
$students = $mysqli->query("SELECT * FROM students ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);

// Fetch courses
$courses = $mysqli->query("SELECT * FROM courses ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);

// Fetch enrollments with joins
$sql = "SELECT e.id,
               CONCAT(s.first_name, ' ', s.last_name) AS student,
               c.code AS course_code,
               c.title AS course_title,
               e.enrolled_at
        FROM enrollments e
        JOIN students s ON s.id = e.student_id
        JOIN courses c ON c.id = e.course_id
        ORDER BY e.enrolled_at DESC";
$enrollments = $mysqli->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Registration Details</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; }
    h2 { margin-top: 32px; }
    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #f3f3f3; }
  </style>
</head>
<body>
  <h1>Student Registration System – All Details</h1>

  <h2>Students</h2>
  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['id']) ?></td>
        <td><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></td>
        <td><?= htmlspecialchars($s['email']) ?></td>
        <td><?= htmlspecialchars($s['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <h2>Courses</h2>
  <table>
    <tr><th>ID</th><th>Code</th><th>Title</th><th>Credit</th><th>Created At</th></tr>
    <?php foreach ($courses as $c): ?>
      <tr>
        <td><?= htmlspecialchars($c['id']) ?></td>
        <td><?= htmlspecialchars($c['code']) ?></td>
        <td><?= htmlspecialchars($c['title']) ?></td>
        <td><?= htmlspecialchars($c['credit']) ?></td>
        <td><?= htmlspecialchars($c['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <h2>Enrollments</h2>
  <table>
    <tr><th>ID</th><th>Student</th><th>Course</th><th>Enrolled At</th></tr>
    <?php foreach ($enrollments as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e['id']) ?></td>
        <td><?= htmlspecialchars($e['student']) ?></td>
        <td><?= htmlspecialchars($e['course_code'] . ' - ' . $e['course_title']) ?></td>
        <td><?= htmlspecialchars($e['enrolled_at']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
