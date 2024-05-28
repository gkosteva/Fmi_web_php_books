<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uploads = isset($_SESSION['my_uploads']) ? $_SESSION['my_uploads'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploads</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css">
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/myUploads.css">
</head>
<body>
<div class="header-container">
    <h1>My PDF Library</h1>
    <ul class="header-links">
        <li><a href="active_books.php">Active Books</a></li>
        <li><a href="/Fmi_web_php_books/handlers/myUploadsHandler.php">My Uploads</a></li>
        <li><a href="/Fmi_web_php_books/views/add_pdf.php">Add PDF</a></li>
        <li><a href="requests.php">Requests</a></li>
        <li><a href="home.php">Home</a></li>
        <li><a href="/Fmi_web_php_books/index.php">Logout</a></li>
    </ul>
</div>

<main>
    <h1>My Uploads</h1>
    <ul id="book-list">
        <?php if (count($uploads) > 0): ?>
            <?php foreach ($uploads as $upload): ?>
                <?php
                    $imageUrl = str_replace('/Applications/XAMPP/xamppfiles/htdocs/', '/', $upload['img']);
                    $pdfUrl = str_replace('/Applications/XAMPP/xamppfiles/htdocs/', '/', $upload['pdf_file']);
                ?>
                <li class="book">
                    <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Cover" class="imgBook">
                    <div class="info">
                        <h2 class="title"><?= htmlspecialchars($upload['title']) ?></h2>
                        <p class="description"><?= htmlspecialchars($upload['descript']) ?></p>
                        <p class="author">Active Users: <?= htmlspecialchars($upload['users_allowed_count']) ?></p>
                    </div>
                    <div class="buttons">
                        <a href="<?= htmlspecialchars($pdfUrl) ?>" target="_blank" class="pathPDF">View PDF</a>
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
