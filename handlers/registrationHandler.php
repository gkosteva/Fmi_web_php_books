<?php

require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/models/user.php';
require_once __DIR__ . '../../common/httpHelpers.php';

use models\User;
use repositories\UsersRepository;

session_start();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeat_password = $_POST['repeatPassword'];

$_SESSION['form_data'] = [
    'username' => $username,
    'email' => $email,
    'password' => $password,
    'repeatPassword' => $repeat_password
];

// Validations
if (empty($email) || empty($password) || empty($username) || empty($repeat_password)) {
    $_SESSION['error'] = "Моля попълнете всички полета.";
    header("Location: ../views/registration.php");
    exit();
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "Паролата трябва да е поне 6 символа.";
    header("Location: ../views/registration.php");
    exit();
}

if (!preg_match('/[A-Z]/', $password)) {
    $_SESSION['error'] = "Паролата трябва да съдържа поне една главна буква.";
    header("Location: ../views/registration.php");
    exit();
}

if (!preg_match('/[a-z]/', $password)) {
    $_SESSION['error'] = "Паролата трябва да съдържа поне една малка буква.";
    header("Location: ../views/registration.php");
    exit();
}

if ($password !== $repeat_password) {
    $_SESSION['error'] = "Паролите трябва да съвпадат.";
    header("Location: ../views/registration.php");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the username already exists
$user_service = new UsersRepository();

if($user_service->getByUsername($username)){
    $_SESSION['error'] = "Това потребителско име е заето. Моля въведете друго потребителско име.";
    header("Location: ../views/registration.php");
    exit();
}

if ($user_service->getByEmail($email)) {
    $_SESSION['error'] = "Този имейл вече съществуава. Моля въведете друг имейл.";
    header("Location: ../views/registration.php");
    exit();
}

// Insert the user data into the database
$current_date=date('Y-m-d H:i:s');
$is_successful = $user_service->create(new User($username, $email, $hashed_password,true));
if ($is_successful) {
    unset($_SESSION['form_data']);
    redirect('../index.php');
} else {
    $_SESSION['error'] = "Грешка по време на регистрацията. Опитай пак!";
    header("Location: ../views/registration.php");
    exit();
}
