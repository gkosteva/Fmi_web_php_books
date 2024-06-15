<?php
session_start();
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : ['email' => '', 'password' => ''];
unset($_SESSION['error']);
unset($_SESSION['form_data']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../public/css/registration.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <div id="errorMessage" class="error-message" data-error="<?php echo htmlspecialchars($errorMessage); ?>" style="display: none;"></div>
        <form id="loginForm" action="../handlers/loginHandler.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>" required>
                <div class="error" id="emailError"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($formData['password']); ?>" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>You don't have an account? <a href="registration.php">Register here</a></p>
        </div>
    </div>
    <script src="../public/js/loginAndRegistrationErrorHandling.js"></script>
</body>
</html>
