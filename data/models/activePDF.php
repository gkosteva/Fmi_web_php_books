<?php

namespace models;

class ActivePDF
{
    public $id;
    public $userId;
    public $pdfId;
    public $isActive;
    public $createdAt;
    public $expiresAt;

    public function __construct($userId, $pdfId, $createdAt, $expiresAt, $id = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->pdfId = $pdfId;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
    }

}
