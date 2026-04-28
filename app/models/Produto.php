<?php

class Produto {

    private $pdo;

    public function __construct(){
        require BASE_PATH . "/config/conexao.php";
        $this->pdo = $pdo;
    }

    public function listar(){
        $sql = $this->pdo->query("
            SELECT p.*, f.nome as fornecedor_nome
            FROM produtos p
            LEFT JOIN fornecedores f ON f.id = p.fornecedor_id
            ORDER BY p.nome ASC
        ");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($dados){

        $sql = $this->pdo->prepare("
            INSERT INTO produtos 
            (nome, descricao, estoque, estoque_minimo, custo, preco, fornecedor_id)
            VALUES 
            (:nome, :descricao, :estoque, :estoque_minimo, :custo, :preco, :fornecedor_id)
        ");

        return $sql->execute([
            ":nome" => $dados['nome'],
            ":descricao" => $dados['descricao'],
            ":estoque" => $dados['estoque'] ?? 0,
            ":estoque_minimo" => $dados['estoque_minimo'] ?? 0,
            ":custo" => str_replace(',', '.', $dados['custo'] ?? 0),
            ":preco" => str_replace(',', '.', $dados['preco'] ?? 0),
            ":fornecedor_id" => $dados['fornecedor_id'] ?: null
        ]);
    }

    public function buscar($id){
        $sql = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $sql->execute([':id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($dados){

        $sql = $this->pdo->prepare("
            UPDATE produtos SET
                nome = :nome,
                descricao = :descricao,
                estoque = :estoque,
                estoque_minimo = :estoque_minimo,
                custo = :custo,
                preco = :preco,
                fornecedor_id = :fornecedor_id
            WHERE id = :id
        ");

        return $sql->execute([
            ":id" => $dados['id'],
            ":nome" => $dados['nome'],
            ":descricao" => $dados['descricao'],
            ":estoque" => $dados['estoque'],
            ":estoque_minimo" => $dados['estoque_minimo'],
            ":custo" => str_replace(',', '.', $dados['custo']),
            ":preco" => str_replace(',', '.', $dados['preco']),
            ":fornecedor_id" => $dados['fornecedor_id'] ?: null
        ]);
    }

    public function excluir($id){
        $sql = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
        return $sql->execute([':id' => $id]);
    }

    // 🔥 NOVO — ALERTA DE ESTOQUE BAIXO
    public function estoqueBaixo()
    {
        $sql = "SELECT id, nome, estoque, estoque_minimo 
                FROM produtos 
                WHERE estoque <= estoque_minimo
                ORDER BY estoque ASC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}