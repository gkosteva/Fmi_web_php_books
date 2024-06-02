<?php

namespace models;

class Token
{
    public function __construct($token, $expiration_date, $id=null)
    {
        $this->id = $id;
        $this->token = $token;
        $this->expiration_date = $expiration_date;

    }

    public $id;
    public $token;
    public $expiration_date;
}