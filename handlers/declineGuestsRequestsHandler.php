<?php
session_start();

require_once __DIR__ . '/../data/repositories/unregisteredRequestsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/models/unregisterRequests.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../data/models/token.php';
require_once __DIR__ . '/../data/repositories/sendEmailsRepository.php';


use repositories\UnregisteredRequestRepository;
use repositories\PDFRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];
    $requestRepo = new UnregisteredRequestRepository();
    $request = $requestRepo->getRequestById($requestId);
    if ($request == null) {
        echo "Invalid request";
        exit();
    }

    $pdfRepository = new PDFRepository();
    $pdf = $pdfRepository->getPDFById($request["pdf_id"]);
    $pdfName = $pdf['title'];

    if (!$pdf) {
        header("Location: /Fmi_web_php_books/handlers/guestRrequestUploadHandler.php");
    }

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
        $mail->addAddress($request['user_email']);

        $mail->isHTML(true);
        $mail->Subject = 'Declined Pdf';
        $mail->Body = "Your request for the pdf \"$pdfName\" has been declined!";

        $mail->send();
        echo "<script>alert('Successfully declined!');</script>";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    $statusUpdate=$requestRepo->updateStatus($requestId, "declined");

    header("Location: /Fmi_web_php_books/handlers/guestRequestUploadHandler.php");
    exit();
} else {
    header("Location: /Fmi_web_php_books/handlers/sguestRequestUploadHandler.php");
    exit();
}

