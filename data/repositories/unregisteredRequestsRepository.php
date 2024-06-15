<?php

namespace repositories;

require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/pdf.php';

use repositories\Repository;
use PDO;


class UnregisteredRequestRepository extends Repository
{

    public function __construct()
    {
        parent::__construct('pdf_requests_unregistered');

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
            "id" => $id
        ]);

        if ($pdfs) {
            return $pdfs[0];
        }

        return null;
    }

    public function findRequestPDFExisting($pdf_id, $user_email, $owner_id): ?array
    {
        $pdf = $this->filter([
            "user_email" => $user_email,
            "pdf_id" => $pdf_id,
            "owner_id"=>$owner_id
        ]);

        if($pdf){
            return $pdf[0];
        }
        else {
            return null;
        }
    }

    public function addRequest($request): bool
    {
        return $this->insert([
            "user_email" => $request->userEmail,
            "pdf_id" => $request->pdfId,
            "request_date" => $request->request_date,
            "status" => $request->status,
            "owner_id" => $request->ownerId,
        ]);
    }

    public function updateStatus($id, $newStatus)
{
    $command = "UPDATE $this->tableName SET status = :newStatus WHERE id = :id";
    $query = $this->database->getConnection()->prepare($command);
    $query->bindValue(':newStatus', $newStatus);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    return $query->execute();
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
