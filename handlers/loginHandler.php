<?php

require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../common/httpHelpers.php';

use repositories\UsersRepository;

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Validations
if (empty($email) || empty($password)) {
    echo "Моля попълнете всички полета.";
    exit();
}

$userService = new UsersRepository();
$user = $userService->getByEmail($email);
if (!$user) {
    echo "Невалидни потребителско име или парола.";
    exit();
}

$storedPassword = $user['password'];
if (password_verify($password, $storedPassword)) {
    $_SESSION['email'] = $user['email'];
    redirect('../views/home.php');
} else {
    echo "Невалидни потребителско име или парола.";
}