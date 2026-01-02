<?php
$mysqli = new mysqli("localhost", "root", "", "student_reg");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "✅✅ Connected successfully to student_reg database!";
