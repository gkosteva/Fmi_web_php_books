<?php
require_once __DIR__ . '/../data/repositories/unregisteredRequestsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';

use repositories\UnregisteredRequestRepository;
use repositories\PDFRepository;

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

$pdfRepository = new PDFRepository();
$pdfIdsOfUser = $pdfRepository->getPDFsByUserId($user_id);

$requestRepository = new UnregisteredRequestRepository();
$requests;
$index = 0;
foreach ($pdfIdsOfUser as &$pdf) {
    $req = $requestRepository->getRequestByPDFId($pdf["id"]);
    foreach ($req as &$r) {
        $requests[$index] = $r;
        $index = $index + 1;
    }
}
$onlyPendingRequests;
$index = 0;
foreach ($requests as &$curReq) {
    if ($curReq['status'] == 'pending') {
        $onlyPendingRequests[$index] = $curReq;
        $index = $index + 1;
    }

}
if (!$onlyPendingRequests) {
    $_SESSION['guestsRequests'] = null;
    header("Location: ../views/guestRequests.php");
    exit();
}

$pdfRepo = new PDFRepository();
$output=array();

foreach ($onlyPendingRequests as &$book) {
    $current = $pdfRepo->getPDFById($book["pdf_id"]);
    $book["title_pdf"] = $current["title"];
    $output[] = $book;
}

$_SESSION['guestsRequests'] = $output;
header("Location: ../views/guestRequests.php");
exit();