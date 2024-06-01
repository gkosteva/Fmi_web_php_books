<?php
require_once __DIR__ . '/../data/repositories/activePDFsRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';

use repositories\PDFRepository;
use repositories\UsersRepository;

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$userId= $_SESSION['user_id'];
$pdfRepository = new PDFRepository();
$userRepo=new UsersRepository();

$searchQuery = $_POST['searchQuery'];

$results=[];

if ($searchQuery=="" || empty($searchQuery)) {
    $results = $pdfRepository->getAll();
}
else{
$results = $pdfRepository->searchPDFs($searchQuery);
}

foreach ($results as &$book) {
    if ($book['owner'] == $user_id) {
        $book=[];
    }
    else{
    $book["owner"] = $userRepo->getUserById($book["owner"]);
    }
}
$_SESSION['result']=$results;

header("Location: ../views/home.php");
