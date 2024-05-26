<?php

namespace repositories;


require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../../data/models/pdf.php';


use models\ActiveBook;

class ActiveBooksRepository {

    public function __construct() {
        parent::__construct('user_pdfs');

    }

    public function getActiveBooksByUserId($userId) {
        $pdfs = $this->filter([
            "user_id" => $userId
        ]);

        if ($pdfs) {
            return $pdfs;
        }
        return [];
    }

}
