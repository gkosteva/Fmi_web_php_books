<?php

require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../common/httpHelpers.php';
require_once __DIR__ . '/../data/models/pdf.php';

use repositories\PDFRepository;
use models\PDF;

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$targetImageDir = '/public/uploads/images/';
$targerPdfDir = '/public/uploads/pdfs/';

$imagePath = $_FILES['image']['tmp_name'];
$pdfPath = $_FILES['pdf']['tmp_name'];

$imageFile = $_FILES['image'];
$pdfFile = $_FILES['pdf'];

$imageFileName = uniqid() . '-' . basename($imageFile['name']);
$pdfFileName = uniqid() . '-' . basename($pdfFile['name']);

$targetImagePath = $targetImageDir . $imageFileName;
$targetPdfPath = $targerPdfDir . $pdfFileName;

$image = file_get_contents($imagePath);
$pdf = file_get_contents($pdfPath);

move_uploaded_file($imagePath, __DIR__ .'/..'. $targetImagePath);
move_uploaded_file($pdfPath, __DIR__ . '/..' . $targetPdfPath);

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
redirect('../views/home.php');
