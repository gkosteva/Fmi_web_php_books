<?php

namespace models;

class PDF
{
    public function __construct($title, $img, $pdf_file, $descript, $file_path, $active_period, $max_users_allowed,
    $owner, $id=null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->img = $img;
        $this->pdf_file = $pdf_file;
        $this->descript=$descript;
        $this->file_path = $file_path;
        $this->active_period = $active_period;
        $this->max_users_allowed = $max_users_allowed;
        $this->users_allowed_count = 0;
        $this->is_active = true;
        $this->owner = $owner;
    }

    public $id;
    public $title;
    public $img;
    public $pdf_file;
    public $descript;
    public $file_path;
    public $active_period;
    public $max_users_allowed;
    public $users_allowed_count;
    public $is_active;
    public $owner;

}