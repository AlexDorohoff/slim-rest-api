<?php

namespace App\storage;

class Database
{
    private $json = '../users.json';

    public function getData()
    {
        if (!$data = @file_get_contents($this->json)) {
            exit('do not reed file');
        }
        return $data;
    }

    public function putData($data)
    {
        if (!@file_put_contents($this->json, json_encode($data))) {
            exit('do not save file');
        }
        return true;
    }


}