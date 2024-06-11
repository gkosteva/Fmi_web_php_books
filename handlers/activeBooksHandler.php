<?php
require_once __DIR__ . '/../data/repositories/activePDFsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';

use repositories\ActiveBooksRepository;
use repositories\PDFRepository;
use repositories\UsersRepository;

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

$activeRepository = new ActiveBooksRepository();
$activeBooks = $activeRepository->getActiveBooksByUserId($user_id);

if (!$activeBooks) {
    $_SESSION['activeBooks'] = [];
    header("Location: ../views/activeBooks.php");
    exit();
}

$pdfRepo = new PDFRepository();
$userRepo = new UsersRepository();

foreach ($activeBooks as &$book) {
    if ($book["access_end_date"] < date("Y-m-d")) {
        $currentPdfFromPdfRepo = $pdfRepo->getPDFById($book["pdf_id"]);
        $currentCount = $currentPdfFromPdfRepo["users_allowed_count"] - 1;
        $pdfRepo->update($book["pdf_id"], $currentCount, "users_allowed_count");
        $deleted = $activeRepository->delete("user_pdf_id", $book["user_pdf_id"]);
        $book = null;
        continue;
    }
    $book["user_id"] = $userRepo->getUserById($book["user_id"]);
    $book["pdf_id"] = $pdfRepo->getPDFById($book["pdf_id"]);
    $ownerId = $book["pdf_id"]["owner"];
    $book["owner_id"] = $userRepo->getUserById($ownerId);
}

$_SESSION['activeBooks'] = $activeBooks;
header("Location: ../views/activeBooks.php");
exit();
