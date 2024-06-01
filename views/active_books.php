<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$books = isset($_SESSION['active_books']) ? $_SESSION['active_books'] : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Books</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css">
    <link rel="stylesheet" href="\Fmi_web_php_books\public\css\uploads.css">
</head>
<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a style="text-decoration: underline;" href="#">Active Books</a></li>
            <li><a href="/Fmi_web_php_books/handlers/myUploadsHandler.php">My Uploads</a></li>
            <li><a href="/Fmi_web_php_books/views/add_pdf.php">Add PDF</a></li>
            <li><a href="/Fmi_web_php_books/views/requests.php">Requests</a></li>
            <li><a href="/Fmi_web_php_books/views/home.php">Home</a></li>
            <li><a href="/Fmi_web_php_books/index.php">Logout</a></li>
        </ul>
    </div>

    <main>
        <h1>Book Library</h1>
        <ul id="book-list">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book):?>
                    <?php


                   
if(substr($book["pdf_id"]["img"], 0, strlen('/Applications/XAMPP/xamppfiles/htdocs/')) === '/Applications/XAMPP/xamppfiles/htdocs/'){
    $imageUrl = str_replace('/Applications/XAMPP/xamppfiles/htdocs/', '/', $book["pdf_id"]['img']);
    $pdfUrl = str_replace('/Applications/XAMPP/xamppfiles/htdocs/', '/', $book["pdf_id"]['pdf_file']);
}
else{
    $imageUrl = str_replace('C:\\xampp\\htdocs\\', '/', $book["pdf_id"]['img']);
    $pdfUrl = str_replace('C:\\xampp\\htdocs\\', '/', $book["pdf_id"]['pdf_file']);
}
                    ?>
                    <li class="book">
                    <div>
                        <img src="<?= htmlspecialchars($imageUrl); ?>" alt="Cover image for <?= htmlspecialchars($book["pdf_id"]['title']); ?>" class="imgBook">
                        <div class="info">
                            <p class="title">Title: <?= htmlspecialchars($book["pdf_id"]['title']); ?></p>
                            <p class="author">Author: <?= htmlspecialchars($book["user_id"]['username']); ?></p>
                            <p class="description">Description: <?= htmlspecialchars($book["pdf_id"]['descript']); ?></p>
                        </div>
                </div>
                            
                <p class="daysLeft">Access due: <?= htmlspecialchars($book['access_end_date']); ?></p>
                <div class="buttons">            
                <div class="button">
                            <a class="pathPDF" href="<?= htmlspecialchars($pdfUrl); ?>" target="_blank" class="pathPDF">Read PDF</a>
                                </div>
                                <button class="finishBook button">Finish</button>
</div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noBooks">No active books available.</p>
            <?php endif; ?>
        </ul>
            </main>

    <script src="/Fmi_web_php_books/public/js/activeBooks.js"></script>
</body>
</html>