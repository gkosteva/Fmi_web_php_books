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
    header("Location: ../views/login.php");
    exit();
}

if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];
    $requestRepo = new RequestRepository();
    $request = $requestRepo->getRequestById($requestId);

    $pdfRepository = new PDFRepository();
    $pdf = $pdfRepository->getPDFById($request["pdf_id"]);
    if (!$pdf) {
        $_SESSION["err"] = "Error approving";
        header("Location:  requestUploadHandler.php");
    }
    $update = $pdfRepository->update($pdf["id"], $pdf["users_allowed_count"] + 1, "users_allowed_count");
    if (!$update) {
        $_SESSION["err"] = "Error updating";
        header("Location:  requestUploadHandler.php");
        exit();
    }

    $date = new DateTime();
    $daysToAdd = $pdf["active_period"];
    $date->modify("+$daysToAdd days");
    $dateExpire = $date->format('Y-m-d');

    $activeBookRepository = new ActiveBooksRepository();
    $active = new ActivePDF($request["user_id"], $request["pdf_id"], date("Y-m-d"), $dateExpire);


    if ($pdf["users_allowed_count"] >= $pdf["max_users_allowed"]) {
        $_SESSION["err"] = "You cannot approve this request right now. Max count of active users reached!";
        header("Location: ../views/requests.php");
        exit();
    }
    $success = $activeBookRepository->create($active);

    if ($success) {
        $_SESSION['msg'] = "Request approved successfully!";
    } else {
        $_SESSION['erroerrrApprove'] = "Failed to approve the request!";
    }

    $deleted = $requestRepo->deleteRequest("request_id", $requestId);
    if (!$deleted) {
        $_SESSION["err"] = "Error";
    }
    header("Location:  requestUploadHandler.php");
    exit();
} else {
    $_SESSION['err'] = "Error approving pdf!";
    header("Location:  requestUploadHandler.php");
    exit();
}

