<?php
session_start();

require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../common/httpHelpers.php';

use repositories\PDFRepository;

if (!isset($_SESSION['user_id'])) {
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$pdfRepository = new PDFRepository();

// Fetch all uploads made by the user
$uploads = $pdfRepository->getPDFsByUserId($user_id);

$_SESSION['my_uploads'] = $uploads;

// Redirect to the my_uploads page (if necessary, or this script can be part of the my_uploads page itself)
redirect("../views/my_uploads.php");
exit();