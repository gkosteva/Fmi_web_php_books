<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: /Fmi_web_php_books/views/login.php");
    exit();
}

// Retrieve user information from session
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$books = $_SESSION['result'] ?? [];

$err = $_SESSION["errorReq"] ?? "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css" />
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/home.css" />
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/uploads.css" />
</head>

<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a href="/Fmi_web_php_books/handlers/activeBooksHandler.php">Active Books</a></li>
            <li><a href="/Fmi_web_php_books/handlers/myUploadsHandler.php">My Uploads</a></li>
            <li><a href="/Fmi_web_php_books/views/add_pdf.php">Add PDF</a></li>
            <li><a href="/Fmi_web_php_books/handlers/requestUploadHandler.php">Requests</a></li>
            <li><a style="text-decoration: underline;" href="#">Home</a></li>
            <li><a href="/Fmi_web_php_books/index.php">Logout</a></li>
        </ul>
    </div>
    <div class="search-container">
        <form id="searchForm" method="POST" action="/Fmi_web_php_books/handlers/searchHandler.php">
            <input type="text" id="searchQuery" name="searchQuery" placeholder="Search here...">
            <button type="submit" id="searchButton">Search</button>
        </form>
    </div>
    <?php echo "<h3 id='err'>$err</h3>"; ?>

    <div id="results" class="results-container">
        <ul id="book-list">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <?php
                    if (substr($book["img"], 0, strlen('/Applications/XAMPP/xamppfiles/htdocs/')) === '/Applications/XAMPP/xamppfiles/htdocs/') {
                        $imageUrl = str_replace('/Applications/XAMPP/xamppfiles/htdocs/', '/', $book['img']);
                    } else {
                        $imageUrl = str_replace('C:\\xampp\\htdocs\\', '/', $book['img']);
                    }
                    ?>
                    <li class="book">
                        <img src="<?= htmlspecialchars($imageUrl); ?>"
                            alt="Cover image for <?= htmlspecialchars($book['title']); ?>" class="imgBook">
                        <div class="info">
                            <p class="title">Title: <?= htmlspecialchars($book['title']); ?></p>
                            <p class="author">Author: <?= htmlspecialchars($book['owner']["username"]); ?></p>
                            <p class="description">Description: <?= htmlspecialchars($book['descript']); ?></p>
                        </div>

                        <div class="buttons">
                            <?php if ($book['owner']['id'] != $user_id): ?>
                                <div class="button">
                                    <a class="pathPDF"
                                        href='/Fmi_web_php_books/handlers/requestHandler.php?pdfId=<?= htmlspecialchars($book['id']); ?>&userId=<?= htmlspecialchars($user_id); ?>&ownerId=<?= htmlspecialchars($book["owner"]['id']); ?>'>Request
                                        PDF</a>
                                <?php endif; ?>
                            </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noBooks">No pdfs found</p>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>