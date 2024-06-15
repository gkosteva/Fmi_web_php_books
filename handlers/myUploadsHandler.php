<?php
session_start();

require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '../../common/httpHelpers.php';

use repositories\PDFRepository;

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$pdfRepository = new PDFRepository();

// Fetch all uploads made by the user
$uploads = $pdfRepository->getPDFsByUserId($user_id);

$_SESSION['myUploads'] = $uploads;

redirect("../views/myUploads.php");
exit();