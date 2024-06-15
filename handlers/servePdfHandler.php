<?php

session_start();
$token=$_GET['token'];
if(!$token){
    header("Location: ../views/expiredLink.php");
    exit();
}
if(!isset($_SESSION['pdf_tokens'][$token])){
    header("Location: ../views/expiredLink.php");
    exit();
}

$pdfPath = $_SESSION['pdf_tokens'][$token];
unset($_SESSION['pdf_tokens'][$token]); 

$file = __DIR__ . '/../public/uploads/pdfs/' . basename($pdfPath);

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit();
} else {
    header("Location: ../views/expiredLink.php");
    exit();
}