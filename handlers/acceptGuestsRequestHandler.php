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
use repositories\SendEmailRepository;
use models\Token;


if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

function generateToken()
{
    return bin2hex(random_bytes(16));
}

$active_period = 7;
function createExpirationTime($active_days, $format = 'Y-m-d H:i:s')
{
    $current_time = new DateTime();
    $current_time->modify("+$active_days days");
    return $current_time->format($format);
}

$tokenString = generateToken();
$expirationDate = createExpirationTime($active_period);

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
        $_SESSION["err"]="Error approving!";
        header("Location: /Fmi_web_php_books/handlers/guestRrequestUploadHandler.php");
    }
    $update = $pdfRepository->update($pdf["id"], $pdf["users_allowed_count"] + 1, "users_allowed_count");
    if (!$update) {
        $_SESSION["err"]="Error approving!";
        header("Location: /Fmi_web_php_books/handlers/guestRrequestUploadHandler.php");
        exit();
    }

    $tokenService = new SendEmailRepository();

    $token = new Token($tokenString, $expirationDate, $request['user_email'], $request['pdf_id']);
    $tokenService->create($token);

    $mail = new PHPMailer(true);

    $link = "http://localhost/Fmi_web_php_books/handlers/verifyLinkHandler.php?token=$tokenString";

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
        $mail->Subject = 'Here is your link';
        $mail->Body = "Your request for the pdf \"$pdfName\" has been approved! Click <a href='$link'>here</a> to open the PDF. This link will expire in 7 days.";

        $mail->send();
        $_SESSION["msg"]="Successfuly approved!";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    $statusAccept="accept";
    $statusUpdate=$requestRepo->updateStatus($requestId, "approved");
    var_dump($statusUpdate);

    header("Location: /Fmi_web_php_books/handlers/guestRequestUploadHandler.php");
    exit();
} else {
    $_SESSION["err"]="Error approving!";
    header("Location: /Fmi_web_php_books/handlers/sguestRequestUploadHandler.php");
    exit();
}

