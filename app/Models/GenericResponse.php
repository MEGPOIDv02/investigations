<?php


namespace App\Models;


class GenericResponse
{
    var $success;
    var $message;
    var $data;

    public function __construct()
    {
        $this->success = false;
    }
}
