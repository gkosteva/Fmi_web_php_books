<?php
session_start();
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : ['username' => '', 'email' => '', 'password' => '', 'repeatPassword' => ''];
unset($_SESSION['error']);
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="/Fmi_web_php_books/public/css/registration.css">
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <div id="errorMessage" class="error-message" data-error="<?php echo htmlspecialchars($errorMessage); ?>" style="display: none;"></div>
        <form id="registrationForm" action="/Fmi_web_php_books/handlers/registrationHandler.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php htmlspecialchars($formData['username']); ?>" required>
                <div class="error" id="usernameError"></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php htmlspecialchars($formData['email']); ?>" required>
                <div class="error" id="emailError"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php htmlspecialchars($formData['password']); ?>" required>
            </div>
            <div class="form-group">
                <label for="repeatPassword">Repeat Password</label>
                <input type="password" id="repeatPassword" name="repeatPassword" value="<?php htmlspecialchars($formData["repeatPassword"]); ?>" required>
                <div class="error" id="passwordError"></div>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="register-link">
            <p>You already have an account? <a href="/Fmi_web_php_books/views/login.php">Login here</a></p>
        </div>
    </div>
    <script src="/Fmi_web_php_books/public/js/loginAndRegistrationErrorHandling.js"></script>
</body>
</html>