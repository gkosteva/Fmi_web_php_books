<?php
session_start();

require_once __DIR__ . '/../data/repositories/requestRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/repositories/activePDFsRepository.php';
require_once __DIR__ . '/../data/models/request.php';
require_once __DIR__ . '/../data/models/activePDF.php';


use repositories\RequestRepository;
use repositories\PDFRepository;

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

    $deleted = $requestRepo->deleteRequest("request_id", $requestId);
    if (!$deleted) {
        $_SESSION["err"] = "Error";
        header("Location:  requestUploadHandler.php");
        exit();
    }
    $_SESSION["msg"] = "Pdf declined!";
    header("Location:  requestUploadHandler.php");
    exit();
} else {
    $_SESSION['err'] = "No request ID provided.";
    header("Location:  requestUploadHandler.php");
    exit();
}

