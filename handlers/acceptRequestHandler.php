<?php
session_start();

require_once __DIR__ . '/../data/repositories/requestRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/repositories/activePDFsRepository.php';
require_once __DIR__ . '/../data/models/request.php';
require_once __DIR__ . '/../data/models/activePDF.php';


use repositories\RequestRepository;
use repositories\ActiveBooksRepository;
use repositories\PDFRepository;
use models\ActivePDF;

if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];
    $requestRepo = new RequestRepository();
    $request = $requestRepo->getRequestById($requestId);

    $pdfRepository = new PDFRepository();
    $pdf = $pdfRepository->getPDFById($request["pdf_id"]);
    if (!$pdf) {
        $_SESSION["errorApprove"] = "Error approving";
        header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
    }
    $update = $pdfRepository->update($pdf["id"], $pdf["users_allowed_count"] + 1, "users_allowed_count");
    if (!$update) {
        $_SESSION["errorApprove"] = "Error updating";
        header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
        exit();
    }

    $date = new DateTime();
    $daysToAdd = $pdf["active_period"];
    $date->modify("+$daysToAdd days");
    $dateExpire = $date->format('Y-m-d');

    $activeBookRepository = new ActiveBooksRepository();
    $active = new ActivePDF($request["user_id"], $request["pdf_id"], date("Y-m-d"), $dateExpire);


    $success = $activeBookRepository->create($active);

    if ($success) {
        $_SESSION['message'] = "Request approved successfully.";
        $_SESSION['errorApprove'] = '';

    } else {
        $_SESSION['errorApprove'] = "Failed to approve the request.";
        $_SESSION['message'] = '';
    }

    $deleted = $requestRepo->deleteRequest("request_id", $requestId);
    if (!$deleted) {
        $_SESSION["errorApprove"] = "Error";
    }
    header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
    exit();
} else {
    $_SESSION['errorApprove'] = "No request ID provided.";
    header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
    exit();
}

