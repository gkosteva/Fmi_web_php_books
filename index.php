<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home</title>
        <link rel="stylesheet" href="public/css/shared.css" />
    </head>
    <body>
        <div class="header-container">
            <h1>My PDF Library</h1>
            <ul class="header-links">
                <li><a href="views/login.php">Login</a></li>
                <li><a href="views/registration.php">Register</a></li>
            </ul>
        </div>
    </body>
</html>
