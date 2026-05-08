<?php

require_once BASE_PATH . "/core/Model.php";

class Fornecedor extends Model
{
    public function listar()
    {
        $sql = "SELECT * FROM fornecedores ORDER BY nome";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function criar($dados)
    {
        $sql = "INSERT INTO fornecedores 
        (nome, cnpj, telefone, email, cep, endereco, numero, bairro, cidade, estado)
        VALUES (:nome, :cnpj, :telefone, :email, :cep, :endereco, :numero, :bairro, :cidade, :estado)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $dados['nome'] ?? '',
            ':cnpj' => $dados['cnpj'] ?? '',
            ':telefone' => $dados['telefone'] ?? '',
            ':email' => $dados['email'] ?? '',
            ':cep' => $dados['cep'] ?? '',
            ':endereco' => $dados['endereco'] ?? '',
            ':numero' => $dados['numero'] ?? '',
            ':bairro' => $dados['bairro'] ?? '',
            ':cidade' => $dados['cidade'] ?? '',
            ':estado' => $dados['estado'] ?? ''
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM fornecedores WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}