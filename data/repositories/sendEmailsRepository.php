<?php

namespace repositories;

use models\Token;

require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../../data/models/token.php';

class SendEmailRepository extends Repository
{
    public function __construct()
    {
        parent::__construct('tokens');
    }

    public function getToken(int $token) {
        return $this->filter(['token' => $token]);
    }
    
    
    public function create(Token $token) {
        return $this->insert([
            "token" => $token->token,
            "expiration_date" => $token->expiration_date,
        ]);
    }

}