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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Upload Form</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css">
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/addPdf.css">
</head>
<body>
    <div class="header-container">
        <h1>My PDF Library</h1>
        <ul class="header-links">
        <li><a href="/Fmi_web_php_books/handlers/activeBooksHandler.php">Active Books</a></li>
            <li><a href="/Fmi_web_php_books/handlers/myUploadsHandler.php">My Uploads</a></li>
            <li><a style="text-decoration: underline;" href="#">Add PDF</a></li>
            <li><a href="#">Requests</a></li>
            <li><a href="/Fmi_web_php_books/views/home.php">Home</a></li>
            <li><a href="/Fmi_web_php_books/index.php">Logout</a></li>
        </ul>
    </div>

    <div class="form-container">
        <h2>Upload Your PDF</h2>
        <form action="/Fmi_web_php_books/handlers/uploadHandler.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Image</label>
                <div class="file-drop-area image-drop-area">
                    <img src="/Fmi_web_php_books/public/widgets/uploadimage.png" alt="Upload Image" class="upload-icon" id="image-preview">
                    <span class="fake-btn">Select Image</span>
                    <input class="file-input" type="file" id="image" name="image" accept="image/*">
                </div>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Short Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="pdf">Upload PDF</label>
                <div class="file-drop-area pdf-drop-area">
                    <img src="/Fmi_web_php_books/public/widgets/uploadpdf.png" alt="Upload PDF" class="upload-icon">
                    <span class="fake-btn">Select PDF</span>
                    <span class="file-msg">or drag & drop PDF file here</span>
                    <input class="file-input" type="file" id="pdf" name="pdf" accept=".pdf" required>
                </div>
            </div>
            <div class="form-group">
                <label for="people">People to Use</label>
                <select id="people" name="people">
                    <option value="" selected disabled>Select a number</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
            <div class="form-group">
                <label for="days">Days Active</label>
                <select id="days" name="days">
                    <option value="7" selected>7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                </select>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
    <script src="/Fmi_web_php_books/public/js/addPdfScripts.js"></script>
</body>
</html>