<?php

require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '../../common/httpHelpers.php';

use repositories\UsersRepository;

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$_SESSION['form_data'] = [
    'email' => $email,
    'password' => $password,
];

// Validations
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Моля попълнете всички полета.";
    header("Location: ../views/login.php");
    exit();
}

$userService = new UsersRepository();
$user = $userService->getByEmail($email);
if (!$user) {
    $_SESSION['error'] = "Невалидни потребителско име или парола.";
    header("Location: ../views/login.php");
    exit();
}

$storedPassword = $user['password'];
if (password_verify($password, $storedPassword)) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    redirect(' statisticsHandlerHomePage.php');
} else {
    $_SESSION['error'] = "Невалидни потребителско име или парола.";
    header("Location:  statisticsHandlerHomePage.php");
    exit();
}
