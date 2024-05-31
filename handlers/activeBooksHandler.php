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

$pdfRepository = new ActiveBooksRepository();
$activeBooks = $pdfRepository->getActiveBooksByUserId($user_id);

if (!$activeBooks) {
    $_SESSION['error'] = "No active books";
    header("Location: ../views/active_books.php");
    exit();
}

$pdfRepo = new PDFRepository();
$userRepo = new UsersRepository();

foreach ($activeBooks as &$book) {
    $book["user_id"] = $userRepo->getUserById($book["user_id"]);
    $book["pdf_id"] = $pdfRepo->getPDFById($book["pdf_id"]);
}

$_SESSION['active_books'] = $activeBooks;
header("Location: ../views/active_books.php");
