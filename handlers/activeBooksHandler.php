<?php

require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../common/httpHelpers.php';
require_once __DIR__ . '/../data/models/pdf.php';

use repositories\ActiveBooksRepository;

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

$pdfRepository = new ActiveBooksRepository();
$activeBooks = $pdfRepository->getActiveBooksByUserId($user_id);

if (!$activeBooks) {
    $_SESSION['error']="error loading files";
    exit();
}
$sql = "expiration_date < NOW()";

$books=$pdfRepository->delete($sql);
$_SESSION['active_books']=$books;

$pdf = $result->fetch_assoc();

// Define the path to the PDF file
$pdfPath = __DIR__ . '/path/to/uploads/' . $pdf['file_name'];  // Adjust path as needed

// Serve the PDF
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename='" . basename($pdfPath) . "'");
readfile($pdfPath);

exit();
