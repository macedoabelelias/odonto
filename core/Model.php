<?php

class Model {

    protected $pdo;

    public function __construct() {
        require_once BASE_PATH . "/config/conexao.php";
        $this->pdo = $pdo;
    }
}