<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uploads = isset($_SESSION['my_uploads']) ? $_SESSION['my_uploads'] : [];
echo "<script>console.log('Debug Objects: " . $uploads . "' );</script>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploads</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css">
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/addPdf.css">
</head>
<body>
<div class="header-container">
    <h1>My PDF Library</h1>
    <ul class="header-links">
        <li><a href="active_books.php">Active Books</a></li>
        <li><a href="my_uploads.php">My Uploads</a></li>
        <li><a href="add_pdf.php">Add PDF</a></li>
        <li><a href="requests.php">Requests</a></li>
        <li><a href="home.php">Home</a></li>
    </ul>
</div>

<main>
    <h1>My Uploads</h1>
    <ul>
        <?php if (count($uploads) > 0): ?>
            <?php foreach ($uploads as $upload): ?>
                <li>
                    <img src="<?= htmlspecialchars($upload['image']) ?>" alt="Cover">
                    <h2><?= htmlspecialchars($upload['title']) ?></h2>
                    <p><?= htmlspecialchars($upload['description']) ?></p>
                    <p>Active Users: <?= htmlspecialchars($upload['active_users_count']) ?></p> <!-- Ensure this column exists -->
                    <a href="<?= htmlspecialchars($upload['pdf_file']) ?>" target="_blank">View PDF</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No uploads available.</p>
        <?php endif; ?>
    </ul>
</main>
</body>
</html>
