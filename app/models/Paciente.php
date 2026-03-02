<?php

require_once BASE_PATH . "/core/Database.php";

class Paciente {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function listar() {

        $sql = $this->pdo->query("SELECT * FROM pacientes ORDER BY id DESC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($dados) {

        $sql = $this->pdo->prepare("
            INSERT INTO pacientes (nome, cpf, telefone)
            VALUES (:nome, :cpf, :telefone)
        ");

        $sql->bindValue(':nome', $dados['nome']);
        $sql->bindValue(':cpf', $dados['cpf']);
        $sql->bindValue(':telefone', $dados['telefone']);
        $sql->execute();
    }

    public function excluir($id) {

        $sql = $this->pdo->prepare("DELETE FROM pacientes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}