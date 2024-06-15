<?php

require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '../../common/httpHelpers.php';
require_once __DIR__ . '/../data/models/pdf.php';

use repositories\PDFRepository;
use models\PDF;

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$targetImageDir = '/public/uploads/images/';
$targetPdfDir = '/public/uploads/pdfs/';

$baseDir = realpath(__DIR__ . '/..'); // Get the absolute path

if (!is_dir($baseDir . $targetImageDir)) {
    mkdir($baseDir . $targetImageDir, 0777, true);
}
if (!is_dir($baseDir . $targetPdfDir)) {
    mkdir($baseDir . $targetPdfDir, 0777, true);
}

$imagePath = $_FILES['image']['tmp_name'];
$pdfPath = $_FILES['pdf']['tmp_name'];

$imageFileName = uniqid() . '-' . basename($_FILES['image']['name']);
$pdfFileName = uniqid() . '-' . basename($_FILES['pdf']['name']);

$targetImagePath = $baseDir . $targetImageDir . $imageFileName;
$targetPdfPath = $baseDir . $targetPdfDir . $pdfFileName;

// Move uploaded files
if (move_uploaded_file($imagePath, $targetImagePath)) {
    $_SESSION["msg"]= "Image upload successful";
} else {
    $_SESSION["err"]= "Image upload failed";
    redirect("myUploadsHandler.php");
    exit();
}

if (move_uploaded_file($pdfPath, $targetPdfPath)) {
    $_SESSION["msg"]= "PDF upload successful";
} else {
    $_SESSION["err"]= "PDF upload failed";
    redirect("myUploadsHandler.php");
    exit();
}

// Handle the form submission
$title = $_POST['title'];
$description = $_POST['description'];
$people = $_POST['people'];
$days = $_POST['days'];

// Create PDF model
$pdf = new PDF($title, $targetImagePath, $targetPdfPath, $description, $targetPdfPath, $days, $people, $user_id);

// Save the PDF details to the database
$pdfRepository = new PDFRepository();
$pdfRepository->create($pdf);

// Redirect to a success page
redirect("myUploadsHandler.php");
