<?php
session_start();
require_once __DIR__ . '/../data/repositories/pdfRepository.php';

use repositories\PDFRepository;

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
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home</title>
        <link rel="stylesheet" href="/Fmi_web_php_books/public/css/shared.css" />
      </head>
<body>
<div class="header-container">
      <h1>My PDF Library</h1>
      <ul class="header-links">
        <li><a href="/Fmi_web_php_books/views/active_books.php">Active Books</a></li>
        <li><a href="/Fmi_web_php_books/handlers/myUploadsHandler.php">My Uploads</a></li>
        <li><a href="/Fmi_web_php_books/views/add_pdf.php">Add PDF</a></li>
        <li><a href="#">Requests</a></li>
        <li><a href="#">Home</a></li>
        <li><a href="/Fmi_web_php_books/views/logout.php">Logout</a></li>
      </ul>
  </div>
</body>