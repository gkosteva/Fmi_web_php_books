<?php

namespace repositories;

use models\User;

require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../../data/models/user.php';

class UsersRepository extends Repository
{
    public function __construct()
    {
        parent::__construct('User');
    }

    public function getByEmail($email) {
        $users = $this->filter([
            "email" => $email
        ]);

        if ($users) {
            return $users[0];
        }

        return null;
    }

    public function getByUsername($username){
        $users = $this->filter([
            "username" => $username
        ]);

        if ($users) {
            return $users[0];
        }

        return null;
    }

    public function getUserById( $userId){
        $users = $this->filter([
            "id" => $userId
        ]);

        if ($users) {
            return $users[0];
        }

        return null;
    }

    public function create(User $user) {
        return $this->insert([
            "email" => $user->email,
            "username" => $user->username,
            "password" => $user->password,
            "is_registered" => $user->is_registered
        ]);
    }
}