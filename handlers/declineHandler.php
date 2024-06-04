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
    if(!$pdf){
        $_SESSION["errorApprove"] = "Error approving";
        header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
    }

    $deleted = $requestRepo->deleteRequest("request_id",$requestId);
    if (!$deleted) {
        $_SESSION["errorApprove"] = "Error";
        header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
        exit();
    }
    $_SESSION["errorApprove"]="Pdf declined!";
    header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
    exit();
} else {
    $_SESSION['errorApprove'] = "No request ID provided.";
    header("Location: /Fmi_web_php_books/handlers/requestUploadHandler.php");
exit();
}

