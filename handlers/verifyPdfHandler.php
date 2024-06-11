<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

$pdfPath = $_GET['pdfPath'];
$token = bin2hex(random_bytes(16));
$_SESSION['pdf_tokens'][$token] = $pdfPath;
$maskedUrl = "http://localhost/Fmi_web_php_books/handlers/servePdfHandler.php?token=$token";

header("Location: $maskedUrl");
exit();

