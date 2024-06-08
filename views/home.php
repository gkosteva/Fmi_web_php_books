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

$error = $_SESSION["err"] ?? '';
$msg = $_SESSION["msg"] ?? '';
unset($_SESSION["err"]);
unset($_SESSION["msg"]);

$statisticsData=$_SESSION['statisticsData'];
$count=count($statisticsData);

$dataPoints = array();

foreach ($statisticsData as $data) {
    $dataPoints[] = array(
        "label" => $data["title"],
        "y" => $data["users_allowed_count"]
    );
}


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
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light1",
                title: {
                    text: "Most read PDFs"
                },
                axisY: {
                    title: "Number of active users"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>

<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a href="/Fmi_web_php_books/handlers/activeBooksHandler.php">Active Books</a></li>
            <li><a href="/Fmi_web_php_books/handlers/myUploadsHandler.php">My Uploads</a></li>
            <li><a href="/Fmi_web_php_books/views/addPdf.php">Add PDF</a></li>
            <li><a href="/Fmi_web_php_books/handlers/requestUploadHandler.php">Requests</a></li>
            <li><a href="/Fmi_web_php_books/handlers/guestRequestUploadHandler.php">Guest requests</a></li>
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
    <div id="chartContainer"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <?php if ($error != '') {
        echo "<h3 id='err' style='color:red;'>$error</h3>";
    } else {
        echo "<h3 id='err'>$msg</h3>";
    } ?>
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
                            _SESSIONalt="Cover image for <?= htmlspecialchars($book['title']); ?>" class="imgBook">
                        <div class="info">
                            <p class="title">Title: <?= htmlspecialchars($book['title']); ?></p>
                            <p class="author">Author: <?= htmlspecialchars($book['owner']['username']); ?></p>
                            <p class="description">Description: <?= htmlspecialchars($book['descript']); ?></p>
                        </div>

                        <div class="buttons">
                            <?php if ($book['owner']['id'] != $user_id): ?>
                                <div class="button">
                                    <a class="pathPDF"
                                        href="/Fmi_web_php_books/handlers/requestHandler.php?pdfId=<?= htmlspecialchars($book['id']); ?>&userId=<?= htmlspecialchars($user_id); ?>&ownerId=<?= htmlspecialchars($book["owner"]['id']); ?>">Request
                                        PDF</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noBooks">No pdfs</p>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>