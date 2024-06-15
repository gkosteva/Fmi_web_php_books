<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$uploads = isset($_SESSION['myUploads']) ? $_SESSION['myUploads'] : [];


$error = $_SESSION['err'] ?? '';
$msg = $_SESSION['msg'] ?? '';

unset($_SESSION['msg']);
unset($_SESSION['err']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploads</title>
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="../public/css/uploads.css">
    <link rel="stylesheet" href="../public/css/home.css">

</head>

<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a href="../handlers/activeBooksHandler.php">Active Books</a></li>
            <li><a style="text-decoration: underline;" href="../handlers/myUploadsHandler.php">My
                    Uploads</a></li>
            <li><a href="addPdf.php">Add PDF</a></li>
            <li><a href="../handlers/requestUploadHandler.php">Requests</a></li>
            <li><a href="../handlers/guestRequestUploadHandler.php">Guest requests</a></li>
            <li><a href="../handlers/statisticsHandlerHomePage.php">Home</a></li>
            <li><a href="../index.php">Logout</a></li>
        </ul>
    </div>

    <main>
    <?php if ($error != '') {
        echo "<h3 id='err' style='color:red;'>$error</h3>";
    } else {
        echo "<h3 id='err'>$msg</h3>";
    } ?>
        <h1>My Uploads</h1>
        <ul id="book-list">
            <?php if (count($uploads) > 0): ?>
                    <?php foreach ($uploads as $upload): ?>
                            <?php
                               $imageUrl = preg_replace('/^.*?(?=public)/', '../', $upload['img']);
                               $pdfUrl = preg_replace('/^.*?(?=public)/', '../', $upload['pdf_file']);

                            ?>
                            <li class="book">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Cover" class="imgBook">
                                <div class="info">
                                    <h2 class="title">Title: <?= htmlspecialchars($upload['title']) ?></h2>
                                    <p class="description">Description: <?= htmlspecialchars($upload['descript']) ?></p>
                                    <p class="author">Active Users: <?= htmlspecialchars($upload['users_allowed_count']) ?></p>
                                </div>
                                <div class="buttons">
                                    <div class="button">
                                        <a href="<?= htmlspecialchars($pdfUrl) ?>" target="_blank" class="pathPDF">View PDF</a>
                                    </div>
                                    <div class="button">
                                        <a href="" class="pathPDF">Share</a>
                                    </div>
                                </div>
                            </li>
                    <?php endforeach; ?>
            <?php else: ?>
                    <p id="noBooks">No uploads available.</p>
            <?php endif; ?>
        </ul>
    </main>
</body>

</html>