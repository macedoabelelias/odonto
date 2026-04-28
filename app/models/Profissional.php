<?php

require_once BASE_PATH . "/core/Model.php";

class Profissional extends Model
{

    public function listar()
    {
        return $this->pdo->query("SELECT * FROM profissionais ORDER BY nome")
                         ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM profissionais WHERE id = :id");
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}