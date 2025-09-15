<?php
// Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'granite_db');

// Email (using PHPMailer - download from https://github.com/PHPMailer/PHPMailer and include)
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function getDB() {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'your_smtp_host'; // e.g., smtp.gmail.com
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com';
    $mail->Password = 'your_app_password';
    $mail->setFrom('your_email@example.com');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $message;
    return $mail->send();
}
?>
