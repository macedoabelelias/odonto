<?php

class Nivel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* ==========================
       LISTAR TODOS
    ========================== */
    public function getAll()
    {
        $sql = "SELECT * FROM niveis ORDER BY nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==========================
       BUSCAR POR ID
    ========================== */
    public function getById($id)
    {
        $sql = "SELECT * FROM niveis WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', (int)$id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================
       CRIAR
    ========================== */
    public function create($nome, $descricao)
    {
        $nome = strtolower(trim($nome));
        $descricao = trim($descricao);

        if (empty($nome)) {
            return false;
        }

        $sql = "INSERT INTO niveis (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $nome,
            ':descricao' => $descricao
        ]);
    }

    /* ==========================
       ATUALIZAR
    ========================== */
    public function update($id, $nome, $descricao)
    {
        $nome = strtolower(trim($nome));
        $descricao = trim($descricao);

        if (empty($nome)) {
            return false;
        }

        $sql = "UPDATE niveis 
                SET nome = :nome, descricao = :descricao 
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => (int)$id,
            ':nome' => $nome,
            ':descricao' => $descricao
        ]);
    }

    /* ==========================
       EXCLUIR
    ========================== */
    public function delete($id)
    {
        // verifica se existem usuários vinculados
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE nivel_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', (int)$id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['total'] > 0) {
            return false; // não permite excluir
        }

        $sql = "DELETE FROM niveis WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id' => (int)$id]);
    }

    public function listar()
{
    $sql = $this->pdo->query("
        SELECT * FROM niveis
        ORDER BY nome ASC
    ");

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
}