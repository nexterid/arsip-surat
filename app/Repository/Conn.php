<?php
namespace App\Repository;

class Conn
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
}