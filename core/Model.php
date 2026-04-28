<?php

class Model
{
    protected $pdo;

    public function __construct()
    {
       require BASE_PATH . "/config/conexao.php";
        $this->pdo = $pdo; 
    }
}