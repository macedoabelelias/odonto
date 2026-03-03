<?php

require_once BASE_PATH . "/core/Database.php";

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function buscarPorId($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarPerfil($id, $dados)
    {
        if (!empty($dados['senha'])) {

            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);

            $sql = $this->pdo->prepare("
                UPDATE usuarios 
                SET nome = :nome,
                    senha = :senha
                WHERE id = :id
            ");

            $sql->bindValue(':senha', $senhaHash);

        } else {

            $sql = $this->pdo->prepare("
                UPDATE usuarios 
                SET nome = :nome
                WHERE id = :id
            ");
        }

        $sql->bindValue(':nome', $dados['nome']);
        $sql->bindValue(':id', $id);

        $sql->execute();
    }
}