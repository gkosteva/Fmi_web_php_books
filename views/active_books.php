<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$books = isset($_SESSION['active_books']) ? $_SESSION['active_books'] : [];
echo "<script>console.log('Debug Objects: " . $books . "' );</script>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Books</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css">
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/activeBook.css">
</head>
<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a href="/Fmi_web_php_books/views/active_books.php">Active Books</a></li>
            <li><a href="/Fmi_web_php_books/views/my_uploads.php">My Uploads</a></li>
            <li><a href="/Fmi_web_php_books/views/add_pdf.php">Add PDF</a></li>
            <li><a href="/Fmi_web_php_books/views/requests.php">Requests</a></li>
            <li><a href="/Fmi_web_php_books/views/home.php">Home</a></li>
        </ul>
    </div>

    <main>
        <h1>Book Library</h1>
        <ul id="book-list">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <li class="book">
                        <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="Cover image for <?php echo htmlspecialchars($book['title']); ?>" class="book-image">
                        <div class="book-info">
                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                            <p><?php echo htmlspecialchars($book['description']); ?></p>
                            <a href="<?php echo htmlspecialchars($book['pdf_file']); ?>" target="_blank">Read PDF</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No active books available.</li>
            <?php endif; ?>
        </ul>
    </main>

    <script src="/Fmi_web_php_books/public/js/activeBooks.js"></script>
</body>
</html>