<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$pdfPath = $_GET['pdfPath'];
$token = bin2hex(random_bytes(16));
$_SESSION['pdf_tokens'][$token] = $pdfPath;
$maskedUrl = "servePdfHandler.php?token=$token";

header("Location: $maskedUrl");
exit();

