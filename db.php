<?php
// config/db.php
$mysqli = new mysqli("localhost", "root", "", "student_reg");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
