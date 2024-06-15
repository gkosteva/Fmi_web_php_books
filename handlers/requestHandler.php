<?php

require_once __DIR__ . '/../data/repositories/requestRepository.php';
require_once __DIR__ . '/../data/repositories/pdfRepository.php';
require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/models/request.php';

session_start();


if (!isset($_GET['pdfId']) || !isset($_GET['userId']) || !isset($_GET['ownerId'])) {
    exit();
}

use repositories\PDFRepository;
use repositories\UsersRepository;
use repositories\RequestRepository;

use models\Request;

$pdfRepository = new PDFRepository();
$userRepo = new UsersRepository();
$requestRepo = new RequestRepository();

$userIdRequested = $_GET['userId'];
$pdfId = $_GET['pdfId'];
$ownerId = $_GET['ownerId'];
$exist = $requestRepo->findRequestPDFExisting($pdfId, $userIdRequested, $ownerId);

if ($exist != null) {
    $_SESSION["err"] = "Already requested!";
    header("Location: ../views/home.php");
    exit();
}

$pdf = $pdfRepository->getPDFById($pdfId);

if ($pdf["users_allowed_count"] >= $pdf["max_users_allowed"]) {
    $_SESSION["err"] = "Try later, full capacity";
    header("Location: ../views/home.php");
    exit();
}
$date = date("Y-m-d");
$createRequest = new Request($userIdRequested, $pdfId, $ownerId, $date, $status);
$request = $requestRepo->addRequest($createRequest);

$title = $pdf["title"];
$_SESSION["msg"] = "Successfully requested pdf: $title!";

header("Location: ../views/home.php");
exit();
