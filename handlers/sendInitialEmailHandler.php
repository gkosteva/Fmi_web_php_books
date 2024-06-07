<?php

require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../data/repositories/unregisteredRequestsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/models/unregisterRequests.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use repositories\PDFRepository;
use repositories\UsersRepository;
use repositories\UnregisteredRequestRepository;
use models\UnregisteredRequest;

session_start();

$email = $_POST['email'];
$pdfName = $_POST['pdfName'];
$authorName = $_POST['authorName'];

$userRepo = new UsersRepository();
$ownerId = $userRepo->getByEmail($authorName);
$authorEmail = $ownerId["email"];

$pdfRepo = new PDFRepository();
$pdfId = $pdfRepo->getPDFByTitle($pdfName);
$requestRepo = new UnregisteredRequestRepository();
$requestDate = date("Y-m-d");
$request = new UnregisteredRequest($email, $pdfId["id"], $ownerId["id"], $requestDate, "pending");
$exist = $requestRepo->findRequestPDFExisting($pdfId["id"], $email, $ownerId["id"]);

if ($exist !== null) {
    echo "Already requested!";
    return;
}
$mail = new PHPMailer(true);
$requestRepo->addRequest($request);

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
    $mail->Body = "Your request for the PDF \"$pdfName\" from $authorEmail is waiting for an approval! We will inform you about the status of your request!";

    $mail->send();
    echo "<script>alert('Successfully requested!');</script>";
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
