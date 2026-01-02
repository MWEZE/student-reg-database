<?php
// Load PHPMailer via Composer
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connect to database
$mysqli = new mysqli("localhost", "root", "", "student_reg");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = trim($_POST['first_name']);
    $last  = trim($_POST['last_name']);
    $email = trim($_POST['email']);

    // Insert into database
    $stmt = $mysqli->prepare("INSERT INTO students (first_name, last_name, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $first, $last, $email);

    if ($stmt->execute()) {
        // Send Gmail notification
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yourgmail@gmail.com';       // your Gmail
            $mail->Password   = 'your-app-password-here';    // 16-digit app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('yourgmail@gmail.com', 'Student Reg System');
            $mail->addAddress('yourgmail@gmail.com'); // send to yourself

            $mail->isHTML(true);
            $mail->Subject = 'New Student Registered';
            $mail->Body    = "
                <h2>New Student Added</h2>
                <p><strong>Name:</strong> {$first} {$last}</p>
                <p><strong>Email:</strong> {$email}</p>
            ";
            $mail->AltBody = "New Student Added\nName: {$first} {$last}\nEmail: {$email}";

            $mail->send();
            echo "✅ Student added and notification sent!";
        } catch (Exception $e) {
            echo "⚠️ Student added, but email failed: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ Error inserting student: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register Student</title>
</head>
<body>
  <h1>Register New Student</h1>
  <form method="post">
    <input name="first_name" placeholder="First name" required>
    <input name="last_name" placeholder="Last name" required>
    <input name="email" type="email" placeholder="Email" required>
    <button type="submit">Register</button>
  </form>
</body>
</html>
