<?php

session_start();

require_once __DIR__ . '/../data/repositories/activePDFsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';

use repositories\ActiveBooksRepository;
use repositories\PDFRepository;

if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

$pdfPath = $_GET['pdfPath'];
$activePdfRepo = new ActiveBooksRepository();
$activePdfs = $activePdfRepo->getActiveBooksByUserId($_SESSION['user_id']);

$pdfRepo = new PDFRepository();
$isFound = false;
foreach ($activePdfs as $pdf) {
    $pdfId = $pdf["pdf_id"];
    $fullInfoPdf = $pdfRepo->getPDFById($pdfId);

    if (strpos($fullInfoPdf["file_path"], $pdfPath) !== false) {
        $isFound = true;
        break;
    }
}
if (!$isFound) {
    header("Location: /Fmi_web_php_books/views/expiredLink.php");
} else {
    $token = bin2hex(random_bytes(16));
    $_SESSION['pdf_tokens'][$token] = $pdfPath;
    $maskedUrl = "http://localhost/Fmi_web_php_books/handlers/servePdfHandler.php?token=$token";
    header("Location: $maskedUrl");
    exit();
}
