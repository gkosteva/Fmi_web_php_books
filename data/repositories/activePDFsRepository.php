<?php

namespace repositories;


require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../../data/models/pdf.php';


use models\ActiveBook;
use repositories\Repository;

class ActiveBooksRepository extends Repository {

    public function __construct() {
        parent::__construct('User_PDFs');

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
