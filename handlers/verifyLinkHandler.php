<?php

session_start();

require_once __DIR__ . '/../data/models/token.php';
require_once __DIR__ . '/../data/repositories/sendEmailsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';

use repositories\SendEmailRepository;
use repositories\PDFRepository;

$token = $_GET['token'];
$emailsRepo = new SendEmailRepository();
$link = $emailsRepo->getToken($token);
if ($link == null) {
    echo "Invalid token!";
    exit();
}

$current_time = new DateTime();
$current_time->format('Y-m-d H:i:s');
$currentTimeInteger=$current_time->getTimestamp();

$pdfId = $link['pdf_id'];
$pdfRepo = new PDFRepository();
$pdf = $pdfRepo->getPDFById($pdfId);
if ($pdf == null) {
    echo "Invalid pdf";
    exit();
}
$pdfPath = $pdf['pdf_file'];

$expirationTimeInteger=strtotime($link['expiration_date']);
if ($currentTimeInteger > $expirationTimeInteger) {
    $currentPdfFromPdfRepo = $pdfRepo->getPDFById($pdfId);
    $currentCount = $currentPdfFromPdfRepo["users_allowed_count"] - 1;
    $pdfRepo->update($pdfId, $currentCount, "users_allowed_count");
    header("Location: ../views/expiredLink.php");
} else {
    $pdfUrl = preg_replace('/^.*?(?=public)/', '/', $pdfPath);

    $expirationToken = bin2hex(random_bytes(16));
    $_SESSION['pdf_tokens'][$expirationToken] = $pdfUrl;
    $maskedUrl = "servePdfHandler.php?token=$expirationToken";
    header("Location: $maskedUrl");
    exit();
}

