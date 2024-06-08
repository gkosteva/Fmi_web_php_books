<?php
require_once __DIR__ . '/../data/repositories/requestRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';

use repositories\RequestRepository;
use repositories\PDFRepository;
use repositories\UsersRepository;

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

$pdfRepository = new PDFRepository();
$pdfIdsOfUser = $pdfRepository->getPDFsByUserId($user_id);

$requestRepository = new RequestRepository();
$requests;
$index = 0;
foreach ($pdfIdsOfUser as &$pdf) {
    $req = $requestRepository->getRequestByPDFId($pdf["id"]);
    foreach ($req as &$r) {
        $requests[$index] = $r;
        $index = $index + 1;
    }
}

if (!$requests) {
    $_SESSION['requests']=[];
    header("Location: ../views/requests.php");
    exit();
}

$pdfRepo = new PDFRepository();
$userRepo = new UsersRepository();

foreach ($requests as &$book) {
    $book["user_id"] = $userRepo->getUserById($book["user_id"]);
    $book["pdf_id"] = $pdfRepo->getPDFById($book["pdf_id"]);
}

$_SESSION['requests'] = $requests;
header("Location: ../views/requests.php");
exit();