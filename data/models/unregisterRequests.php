<?php

namespace models;

class UnregisteredRequest
{
    public function __construct($userEmail, $pdfId, $ownerId, $request_date, $status, $id = null)
    {
        $this->id = $id;
        $this->userEmail = $userEmail;
        $this->pdfId = $pdfId;
        $this->ownerId = $ownerId;
        $this->request_date = $request_date;
        $this->status = $status;
    }
    public $id;
    public $userEmail;
    public $pdfId;
    public $request_date;
    public $status;
    public $ownerId;

}
