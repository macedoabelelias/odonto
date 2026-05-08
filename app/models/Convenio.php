<?php

require_once BASE_PATH . "/core/Model.php";

class Convenio extends Model
{
    public function listar()
    {
        $sql = "SELECT * FROM convenios ORDER BY nome ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convenios WHERE id = :id"); // 🔥 CORRIGIDO
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO convenios (nome, percentual, valor_us)
            VALUES (:nome, :percentual, :valor_us)
        ");

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':percentual' => $dados['percentual'],
            ':valor_us' => $dados['valor_us']
        ]);
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare("
            UPDATE convenios 
            SET nome = :nome, percentual = :percentual, valor_us = :valor_us
            WHERE id = :id
        ");

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':percentual' => $dados['percentual'],
            ':valor_us' => $dados['valor_us'],
            ':id' => $id
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM convenios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}