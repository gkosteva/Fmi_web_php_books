<?php

namespace repositories;

use models\PDF;

require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../../data/models/pdf.php';

class PDFRepository extends Repository
{
    public function __construct()
    {
        parent::__construct('pdfs');
    }

    public function getPDFByDescr($descript) {
        $pdfs = $this->filter([
            "descript" => $descript
        ]);

        if ($pdfs) {
            return $pdfs[0];
        }

        return null;
    }

    public function getPDFByTitle($title) {
        $pdfs = $this->filter([
            "title" => $title
        ]);

        if ($pdfs) {
            return $pdfs[0];
        }

        return null;
    }

    public function getPDFsByUserId(int $user_id) {
        return $this->filter($user_id);
    }
    
    
    public function create(PDF $pdf) {
        return $this->insert([
            "title" => $pdf->title,
            "img" => $pdf->img,
            "pdf_file" => $pdf->pdf_file,
            "descript" => $pdf->descript,
            "file_path" => $pdf->file_path,
            "active_period" => $pdf->active_period,
            "max_users_allowed" => $pdf->max_users_allowed,
            "users_allowed_count"=> $pdf->users_allowed_count,
            "is_active" => true,
            "owner"=> $pdf->owner
        ]);
    }

}