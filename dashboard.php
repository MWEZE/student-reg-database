<?php
require_once __DIR__ . '/config/db.php';

// Handle CREATE
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $stmt = $mysqli->prepare("INSERT INTO students (first_name, last_name, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['first_name'], $_POST['last_name'], $_POST['email']);
    $stmt->execute();
}

// Handle UPDATE
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $stmt = $mysqli->prepare("UPDATE students SET first_name=?, last_name=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['id']);
    $stmt->execute();
}

// Handle DELETE
if (isset($_GET['delete'])) {
    $stmt = $mysqli->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
}

// Fetch all students
$result = $mysqli->query("SELECT * FROM students ORDER BY id ASC");
$students = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; background-image: linear-gradient(to right, #88ccedff, #26849eff); }
    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #e1e11eff; }
    form { margin-bottom: 20px; }
    input { padding: 6px; margin-right: 8px; }
    button { padding: 6px 12px; }
    a href { color: red; text-decoration: none; margin-left: 8px; }
  </style>
</head>
<body>
  <h1>Student CRUD Dashboard</h1>

  <!-- CREATE FORM -->
  <h2>Add Student</h2>
  <form method="post">
    <input type="hidden" name="action" value="create">
    <input name="first_name" placeholder="First name" required>
    <input name="last_name" placeholder="Last name" required>
    <input name="email" type="email" placeholder="Email" required>
    <button type="submit">Add</button>
  </form>

  <!-- STUDENT TABLE -->
  <h2>All Students</h2>
  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['id']) ?></td>
        <td><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></td>
        <td><?= htmlspecialchars($s['email']) ?></td>
        <td>
          <!-- UPDATE FORM -->
          <form method="post" style="display:inline;">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $s['id'] ?>">
            <input name="first_name" value="<?= htmlspecialchars($s['first_name']) ?>">
            <input name="last_name" value="<?= htmlspecialchars($s['last_name']) ?>">
            <input name="email" type="email" value="<?= htmlspecialchars($s['email']) ?>">
            <button type="submit">Update</button>
          </form>
          <!-- DELETE LINK -->
          <a href="?delete=<?= $s['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
