<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = new mysqli("localhost", "root", "", "student_reg");

    $first = $_POST['first_name'];
    $last  = $_POST['last_name'];
    $email = $_POST['email'];

    $stmt = $mysqli->prepare("INSERT INTO students (first_name, last_name, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $first, $last, $email);

    if ($stmt->execute()) {
        echo "✅ Student added successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
?>

<form method="post">
  <input name="first_name" placeholder="First name" required>
  <input name="last_name" placeholder="Last name" required>
  <input name="email" type="email" placeholder="Email" required>
  <button type="submit">Add Student</button>
</form>
--- IGNORE ---
