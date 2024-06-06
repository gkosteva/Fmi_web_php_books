<?php

namespace models;

class Request
{
    public function __construct($userId, $pdfId, $ownerId, $request_date, $status, $id = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->pdfId = $pdfId;
        $this->request_date = $request_date;
        $this->status = $status;
        $this->ownerId = $ownerId;
    }
    public $id;
    public $userId;
    public $pdfId;
    public $request_date;
    public $status;
    public $ownerId;

}
