<?php

namespace models;

 class User
{
    public function __construct($username, $email, $password, $is_registered, $id=null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->is_registered=$is_registered;

    }

    public $id;
    public $username;
    public $email;
    public $password;
    public $is_registered;
}