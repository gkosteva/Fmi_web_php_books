<?php

namespace models;

class Token
{
    public function __construct($token, $expirationDate, $userEmail, $pdfId, $id = null)
    {
        $this->id = $id;
        $this->token = $token;
        $this->expiration_date = $expirationDate;
        $this->pdfId = $pdfId;
        $this->userEmail = $userEmail;
    }

    public $id;
    public $token;
    public $expiration_date;
    public $userEmail;
    public $pdfId;
}