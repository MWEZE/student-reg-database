<?php
$mysqli = new mysqli("localhost", "root", "", "student_reg");

$result = $mysqli->query("SELECT id, first_name, last_name, email FROM students");

echo "<h2>Students</h2>";
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['id'] . " - " . $row['first_name'] . " " . $row['last_name'] . " (" . $row['email'] . ")</li>";
}
echo "</ul>";
?>
