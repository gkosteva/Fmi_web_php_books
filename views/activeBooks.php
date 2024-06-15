<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$books = isset($_SESSION['activeBooks']) ? $_SESSION['activeBooks'] : [];
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
    <title>Active Books</title>
    <link rel="stylesheet" href="../public/css/home.css">
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="../public/css/uploads.css">
</head>

<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a style="text-decoration: underline;" href="#">Active Books</a></li>
            <li><a href=" ../handlers/myUploadsHandler.php">My Uploads</a></li>
            <li><a href="addPdf.php">Add PDF</a></li>
            <li><a href=" ../handlers/requestUploadHandler.php">Requests</a></li>
            <li><a href=" ../handlers/guestRequestUploadHandler.php">Guest requests</a></li>
            <li><a href=" ../handlers/statisticsHandlerHomePage.php">Home</a></li>
            <li><a href=" ../index.php">Logout</a></li>
        </ul>
    </div>

    <main>
        <?php if ($error != '') {
            echo "<h3 id='err' style='color:red;'>$error</h3>";
        } else {
            echo "<h3 id='err'>$msg</h3>";
        } ?>
        <h1>Book Library</h1>
        <ul id="book-list">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <?php if ($book !== null): ?>
                        <?php
                            $imageUrl = preg_replace('/^.*?(?=public)/', '../', $book["pdf_id"]['img']);
                            $pdfUrl = preg_replace('/^.*?(?=public)/', '../', $book["pdf_id"]['pdf_file']);

                            $today = new DateTime();
                            $end = new DateTime($book['access_end_date']);

                            // Calculate the difference
                            $interval = $today->diff($end);
                        ?>
                        <li class="book">
                            <div>
                                <img src="<?= htmlspecialchars($imageUrl); ?>"
                                    alt="Cover image for <?= htmlspecialchars($book["pdf_id"]['title']); ?>" class="imgBook">
                                <div class="info">
                                    <p class="title">Title: <?= htmlspecialchars($book["pdf_id"]['title']); ?></p>
                                    <p class="author">Author: <?= htmlspecialchars($book['owner_id']['username']); ?></p>
                                    <p class="description">Description: <?= htmlspecialchars($book["pdf_id"]['descript']); ?></p>
                                </div>
                            </div>

                            <p class="daysLeft">Access due: <?= htmlspecialchars($book['access_end_date']); ?> (<?= htmlspecialchars($interval->days);?> days left)</p>
                            <div class="buttons">
                                <div class="button">
                                    <a class="pathPDF" href="../handlers/verifyPdfHandler.php?pdfPath=<?= htmlspecialchars($pdfUrl); ?>" target="_blank">Read
                                        PDF</a>
                                </div>
                                <div class='finishBook button'>
                                    <a class='pathPDF'
                                        href=" ../handlers/finishHandler.php?requestId=<?= htmlspecialchars($book["user_pdf_id"]); ?>">Finish</a>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noBooks">No active books available.</p>
            <?php endif; ?>
        </ul>
    </main>

    <script src=" ../public/js/activeBooks.js"></script>
</body>

</html>