<?php
session_start();

require_once __DIR__ . '/../data/repositories/requestRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/repositories/activePDFsRepository.php';
require_once __DIR__ . '/../data/models/request.php';
require_once __DIR__ . '/../data/models/activePDF.php';


use repositories\ActiveBooksRepository;
use repositories\PDFRepository;

if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];

    $activeRepository = new ActiveBooksRepository();
    $pdfRepo = new PDFRepository();
    $pdf = $activeRepository->getActiveBookById($requestId);
    $pdfId = $pdf['pdf_id'];

    if (!$pdf) {
        $_SESSION["err"] = "Error approving";
        header("Location: /Fmi_web_php_books/handlers/activeBooksHandler.php");
    }

    $deleted = $activeRepository->delete("user_pdf_id", $requestId);
    if (!$deleted) {
        $_SESSION["err"] = "Error";
        header("Location: /Fmi_web_php_books/handlers/activeBooksHandler.php");
        exit();
    }
    $currentPdfFromPdfRepo = $pdfRepo->getPDFById($pdfId);
    $currentCount = $currentPdfFromPdfRepo["users_allowed_count"] - 1;
    $pdfRepo->update($pdfId, $currentCount, "users_allowed_count");

    $_SESSION["msg"] = "Succesfully finished!";
    header("Location: /Fmi_web_php_books/handlers/activeBooksHandler.php");
    exit();
} else {
    $_SESSION['err'] = "Error finishing pdf!";
    header("Location: /Fmi_web_php_books/handlers/activeBooksHandler.php");
    exit();
}

