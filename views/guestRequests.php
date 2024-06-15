<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location:  ../views/login.php");
    exit();
}

// Retrieve user information from session
$user_id = $_SESSION['user_id'];
$guestsRequests = $_SESSION['guestsRequests'] ?? [];

$error = $_SESSION['err'] ?? '';
$msg = $_SESSION['msg'] ?? '';

unset($_SESSION['msg']);
unset($_SESSION['err']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Requests</title>
    <link rel="stylesheet" href=" ../public/css/home.css" />
    <link rel="stylesheet" href=" ../public/css/shared.css" />
    <link rel="stylesheet" href=" ../public/css/uploads.css" />
</head>

<body>

    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
            <li><a href=" ../handlers/activeBooksHandler.php">Active Books</a></li>
            <li><a href=" ../handlers/myUploadsHandler.php">My Uploads</a></li>
            <li><a href=" ../views/addPdf.php">Add PDF</a></li>
            <li><a href=" ../handlers/requestUploadHandler.php">Requests</a></li>
            <li><a style="text-decoration: underline;" href="#">Guest requests</a></li>
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

        <h1>Pending guests' requests</h1>
        <ul id="book-list">
            <?php if (count($guestsRequests) > 0): ?>
                <?php for ($i = 0; $i < count($guestsRequests); $i++): ?>
                    <li class='book'>
                        <!-- Ensure to echo out the contents properly -->
                        <h3>Title: <?= htmlspecialchars($guestsRequests[$i]["pdf_id"]['title']); ?></h3>
                        <p>Requested by: <?= htmlspecialchars($guestsRequests[$i]["user_email"]); ?></p>
                        <div class='buttons'>
                            <div class='button'>
                                <!-- Correct the href attribute by echoing and encoding the URL parameter -->
                                <a class='pathPDF'
                                    href=" ../handlers/acceptGuestsRequestHandler.php?requestId=<?= urlencode($guestsRequests[$i]['id']); ?>">Approve</a>
                            </div>
                            <div class='button decline'>
                                <a class='pathPDF'
                                    href=" ../handlers/declineGuestsRequestsHandler.php?requestId=<?= urlencode($guestsRequests[$i]['id']); ?>">Decline</a>
                            </div>
                        </div>
                    </li>
                <?php endfor; ?>
            <?php else: ?>
                <p id="noBooks">No pending requests</p>
            <?php endif; ?>
        </ul>
    </main>

</body>

</html>