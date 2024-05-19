<?php

require_once __DIR__ . '/../data/repositories/userRepository.php';
require_once __DIR__ . '/../data/models/user.php';
require_once __DIR__ . '/../common/httpHelpers.php';

use models\User;
use repositories\UsersRepository;

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeat_password = $_POST['repeatPassword'];

// Validations
if (empty($email) || empty($password) || empty($username) || empty($repeat_password)) {
    echo "Моля попълнете всички полета.";
    exit();
}

if (strlen($password) < 6) {
    echo "Паролата трябва да е поне 6 символа";
    exit();
}

if (!preg_match('/[A-Z]/', $password)) {
    echo "Паролата трябва да съдържа поне една главна буква.";
    exit();
}

if (!preg_match('/[a-z]/', $password)) {
    echo "Паролата трябва да съдържа поне една малка буква.";
    exit();
}

if ($password !== $repeat_password) {
    echo "Паролите трябва да съвпадат.";
    exit();
}


$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the username already exists
$user_service = new UsersRepository();

if($user_service->getByUsername($username)){
    echo "Това потребителско име е заето. Моля въведете друго потребителско име.";
    exit();
}

if ($user_service->getByEmail($email)) {
    echo "Този имейл вече съществуава. Моля въведете друг имейл.";
    exit();
}

// Insert the user data into the database
$current_date=date('Y-m-d H:i:s');
$is_successful = $user_service->create(new User($username, $email, $hashed_password,"REGISTERED_USER",true, 0, $current_date, $current_date));
if ($is_successful) {
    echo "Успешна регистрация.";
    redirect('../index.php');
} else {
    echo "Грешка по време на регистрацията.";
}

