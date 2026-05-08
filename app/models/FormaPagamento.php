<?php

require_once BASE_PATH . "/core/Model.php";

class FormaPagamento extends Model
{

    /* ==========================
       LISTAR TODAS
    ========================== */
    public function listar()
    {
        $sql = $this->pdo->query("
            SELECT * 
            FROM formas_pagamento
            ORDER BY nome ASC
        ");

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ==========================
       BUSCAR POR ID
    ========================== */
    public function buscarPorId($id)
    {
        $sql = $this->pdo->prepare("
            SELECT * 
            FROM formas_pagamento
            WHERE id = :id
        ");

        $sql->bindValue(":id", $id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }


    /* ==========================
       SALVAR (CRIAR)
    ========================== */
    public function salvar($dados)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO formas_pagamento 
            (nome, taxa, ativo)
            VALUES 
            (:nome, :taxa, :ativo)
        ");

        $sql->bindValue(":nome", $dados['nome']);
        $sql->bindValue(":taxa", $dados['taxa'] ?? 0);
        $sql->bindValue(":ativo", $dados['ativo'] ?? 1);

        return $sql->execute();
    }


    /* ==========================
       ATUALIZAR
    ========================== */
    public function atualizar($id, $dados)
    {
        $sql = $this->pdo->prepare("
            UPDATE formas_pagamento SET
                nome = :nome,
                taxa = :taxa,
                ativo = :ativo
            WHERE id = :id
        ");

        $sql->bindValue(":nome", $dados['nome']);
        $sql->bindValue(":taxa", $dados['taxa'] ?? 0);
        $sql->bindValue(":ativo", $dados['ativo'] ?? 1);
        $sql->bindValue(":id", $id);

        return $sql->execute();
    }


    /* ==========================
       EXCLUIR
    ========================== */
    public function excluir($id)
    {
        $sql = $this->pdo->prepare("
            DELETE FROM formas_pagamento
            WHERE id = :id
        ");

        $sql->bindValue(":id", $id);

        return $sql->execute();
    }


    /* ==========================
       LISTAR SOMENTE ATIVOS
    ========================== */
    public function listarAtivos()
    {
        $sql = $this->pdo->query("
            SELECT * 
            FROM formas_pagamento
            WHERE ativo = 1
            ORDER BY nome ASC
        ");

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}