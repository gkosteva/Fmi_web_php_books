<?php

namespace models;

class User
{
    public function __construct($username, $email, $password, $role, $is_registered, $active_uploads_count, $created_at, $updated_at)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
        $this->is_registered=$is_registered;
        $this->active_uploads_count=$active_uploads_count;
        $this->created_at=$created_at;
        $this->updated_at=$updated_at;

    }

    public $username;
    public $email;
    public $password;
    public $is_registered;
    public $role;
    public $active_uploads_count;
    public $created_at;
    public $updated_at;
}