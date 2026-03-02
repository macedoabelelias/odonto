<?php

require_once BASE_PATH . "/core/Database.php";

class Prontuario {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function listarPorPaciente($paciente_id)
    {
        $sql = $this->pdo->prepare("
            SELECT * FROM prontuarios
            WHERE paciente_id = :paciente_id
            ORDER BY id DESC
        ");
        $sql->bindValue(':paciente_id', $paciente_id);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($dados)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO prontuarios (paciente_id, observacoes)
            VALUES (:paciente_id, :observacoes)
        ");

        $sql->bindValue(':paciente_id', $dados['paciente_id']);
        $sql->bindValue(':observacoes', $dados['observacoes']);

        $sql->execute();
    }
}