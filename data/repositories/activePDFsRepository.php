<?php

namespace repositories;


require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../../data/models/pdf.php';


use models\ActivePDF;

class ActiveBooksRepository extends Repository
{

    public function __construct()
    {
        parent::__construct('user_pdfs');
    }

    public function getActiveBooksByUserId($userId)
    {
        $pdfs = $this->filter([
            "user_id" => $userId
        ]);

        return $pdfs;

    }

    public function getActiveBookById($id)
    {
        $pdfs = $this->filter([
            "user_pdf_id" => $id
        ]);

        return $pdfs[0];

    }

    public function delete($column, $id): bool
    {
        $deleted = $this->deleteRecord($column, $id);
        if ($deleted) {
            return true;
        }
        return false;
    }

    public function create(ActivePDF $pdf)
    {
        return $this->insert([
            "user_id" => $pdf->userId,
            "pdf_id" => $pdf->pdfId,
            "access_start_date" => $pdf->createdAt,
            "access_end_date" => $pdf->expiresAt,
        ]);
    }

}
