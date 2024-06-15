<?php
session_start();

require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '../../common/httpHelpers.php';

use repositories\PDFRepository;

$pdf = new PDFRepository();
$pdfs = $pdf->getAll();

usort($pdfs, function($a, $b) {
    return $b->users_allowed_count - $a->users_allowed_count;
});

$topPdfs = array_slice($pdfs, 0, 5);
$_SESSION['statisticsData']= $topPdfs;

header("Location: ../views/home.php");