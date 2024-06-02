<?php

require_once __DIR__ .'/../PHPMailer/Exception.php';
require_once __DIR__ .'/../PHPMailer/SMTP.php';
require_once __DIR__ .'/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../data/models/token.php';
require_once __DIR__ . '/../data/repositories/sendEmailsRepository.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use repositories\SendEmailRepository;
use models\Token;

session_start();

function generateToken() {
    return bin2hex(random_bytes(16));
}

// $active_period=$_SESSION['acrive_period'];
$active_period=7;

function createExpirationTime($active_days, $format = 'Y-m-d H:i:s') {
    $current_time = new DateTime(); 
    $current_time->modify("+$active_days days"); 
    return $current_time->format($format); 
}

$tokenString = generateToken();
$expirationDate = createExpirationTime($active_period);

$tokenService=new SendEmailRepository();

$token= new Token($tokenString, $expirationDate);

$tokenService->create($token);
echo "OK";
exit();

$link = "http://localhost/Fmi_web_php_books/views/verify.php?token=$tokenString";

$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fintracker96@gmail.com';
    $mail->Password = 'uvouppqwzarrbmrf';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('fintracker96@gmail.com', 'PDFs Library');
    $mail->addAddress('gkosteva@uni-sofia.bg');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Here is your link';
    $mail->Body    = "Click <a href='http://localhost/djxwuiew8dxwbjw'>here</a> to open the PDF. This link will expire in 7 days.";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
