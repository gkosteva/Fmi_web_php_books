<?php

namespace models;

class ActivePDF {
    private $id;
    private $userId;
    private $pdfId;
    private $isActive;
    private $createdAt;
    private $expiresAt;

    public function __construct($id, $userId, $pdfId, $isActive, $createdAt, $expiresAt) {
        $this->id = $id;
        $this->userId = $userId;
        $this->pdfId = $pdfId;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
    }

   }
