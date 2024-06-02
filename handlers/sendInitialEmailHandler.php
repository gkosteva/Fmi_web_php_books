<?php

require_once __DIR__ .'/../PHPMailer/Exception.php';
require_once __DIR__ .'/../PHPMailer/SMTP.php';
require_once __DIR__ .'/../PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$email = $_POST['email'];
$pdfName = $_POST['pdfName']; 
$authorName = $_POST['authorName'];

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fintracker96@gmail.com';
    $mail->Password = 'uvouppqwzarrbmrf';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('fintracker96@gmail.com', 'PDFs Library');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'PDF Request';
    $mail->Body    = "Your request for the PDF \"$pdfName\" from $authorName is waiting for an approval! We will inform you about the status of your request!";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
