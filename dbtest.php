<?php
$mysqli = new mysqli("localhost", "root", "", "student_reg");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM students");

while ($row = $result->fetch_assoc()) {
    echo $row['first_name'] . " " . $row['last_name'] . " - " . $row['email'] . "<br>";
}
