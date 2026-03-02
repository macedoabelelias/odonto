<?php

require_once BASE_PATH . "/core/Database.php";

class Odontograma {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function salvar($dados)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO odontograma_registros 
            (paciente_id, dente, face, status)
            VALUES (:paciente_id, :dente, :face, :status)
        ");

        $sql->bindValue(':paciente_id', $dados['paciente_id']);
        $sql->bindValue(':dente', $dados['dente']);
        $sql->bindValue(':face', $dados['face']);
        $sql->bindValue(':status', $dados['status']);

        $sql->execute();
    }
}