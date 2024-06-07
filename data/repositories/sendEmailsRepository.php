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

    public function getToken(string $token)
    {
        $command = "SELECT * FROM tokens WHERE token = :token";
        $query = $this->database->getConnection()->prepare($command);
        $query->bindParam(':token', $token);
        $query->execute();
        return $query->fetch();
    }

    public function create(Token $token)
    {
        return $this->insert([
            "token" => $token->token,
            "expiration_date" => $token->expiration_date,
            "user_email" => $token->userEmail,
            "pdf_id" => $token->pdfId
        ]);
    }

}