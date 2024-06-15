<?php

namespace repositories;

require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/pdf.php';

use repositories\Repository;


class RequestRepository extends Repository
{

    public function __construct()
    {
        parent::__construct('pdf_requests');

    }

    public function __destruct()
    {
        $this->database->close();
    }

    public function getRequestByPDFId($id): ?array
    {
        return $this->filter([
            "pdf_id" => $id
        ]);
    }
    public function getRequestsOfCurrentUser($id): ?array{
        return $this->filter([
            "owner_id" => $id
        ]);
    }
    public function getRequestById($id): ?array
    {
        $pdfs = $this->filter([
            "request_id" => $id
        ]);

        if ($pdfs) {
            return $pdfs[0];
        }

        return null;
    }

    public function findRequestPDFExisting($pdf_id, $user_id, $owner_id): ?array
    {
        $pdf = $this->filter([
            "user_id" => $user_id,
            "pdf_id" => $pdf_id,
            "owner_id"=>$owner_id
        ]);

        if($pdf){
            return $pdf[0];
        }
        return null;
    }

    public function addRequest($pdf): bool
    {
        return $this->insert([
            "user_id" => $pdf->userId,
            "pdf_id" => $pdf->pdfId,
            "request_date" => $pdf->request_date,
            "status" => $pdf->status,
            "owner_id" => $pdf->ownerId,
        ]);
    }

    public function deleteRequest($column, $id): bool
    {
        $deleted = $this->deleteRecord($column, $id);
        if ($deleted) {
            return true;
        }
        return false;
    }
}
