<?php
require_once __DIR__ . '/data/repositories/pdfRepository.php';
require_once __DIR__ . '/data/repositories/userRepository.php';
require_once __DIR__ . '/common/httpHelpers.php';

use repositories\PDFRepository;
use repositories\UsersRepository;

session_start();

// Clear session
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();

$pdfRepo = new PDFRepository();
$userRepo = new UsersRepository();

$result = $pdfRepo->getAll();
$count = count($result);

shuffle($result);
$selected_pdfs = array_slice($result, 0, min(5, $count));
$updated_pdfs = array();

foreach ($selected_pdfs as $pdf) {
    $owner = $userRepo->getUserById($pdf["owner"]);
    $pdf["owner_email"] = $owner['email'];
    $updated_pdfs[] = $pdf;
}

$msg = $_SESSION['msg'] ?? '';
$error = $_SESSION["err"] ?? '';

unset($_SESSION['msg']);
unset($_SESSION['err']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="public/css/shared.css">
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/uploads.css">
</head>

<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a href="views/login.php">Login</a></li>
            <li><a href="views/registration.php">Register</a></li>
        </ul>
    </div>

    <div class="disclaimer-message">
        You are not logged in. You can only read PDFs accessed via email links, which expire after 7 days. To use all
        features of this site, please log in or register.
    </div>

    <?php if ($error != '') {
        echo "<h3 id='err' style='color:red;'>$error</h3>";
    } else {
        echo "<h3 id='err'>$msg</h3>";
    } ?>

    <div id="results" class="results-container">
        <ul id="book-list">
            <?php if (!empty($updated_pdfs)): ?>
                <?php foreach ($updated_pdfs as $pdf): ?>
                    <?php
                   $imageUrl = preg_replace('/^.*?(?=public)/', '', $pdf['img']);
                    ?>
                    <li class="book">
                        <img src="<?= htmlspecialchars($imageUrl); ?>"
                            alt="Cover image for <?= htmlspecialchars($pdf['title']); ?>" class="imgBook">
                        <div class="info">
                            <p class="title">Title: <?= htmlspecialchars($pdf['title']); ?></p>
                            <p class="author">Author: <?= htmlspecialchars($pdf["owner_email"]); ?></p>
                            <p class="description">Description: <?= htmlspecialchars($pdf['descript']); ?></p>
                        </div>

                        <div class="button request-pdf-button">Request PDF</div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noBooks">No PDFs found</p>
            <?php endif; ?>
        </ul>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal')">&times;</span>
            <h2>Request PDF</h2>
            <p>To request this PDF, please enter your email address. You will receive the PDF via email as soon as the
                owner approves it.</p>
            <div id="loading-indicator" style="display: none;">
                Sending...
            </div>
            <form id="emailForm">
                <input type="email" id="emailInput" placeholder="Enter your email address" required>
                <br>
                <button type="submit" id="submitButton">Submit</button>
            </form>
        </div>
    </div>
    <script src="public/js/index.js"></script>
</body>

</html>