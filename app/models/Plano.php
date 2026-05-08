<?php

require_once BASE_PATH . "/core/Model.php";

class Plano extends Model
{
    public function listarPorPaciente($paciente_id)
    {
        $sql = $this->pdo->prepare("
            SELECT 
                plano_itens.*, 
                procedimentos.nome, 
               procedimentos.valor_particular AS valor
            FROM plano_itens
            LEFT JOIN procedimentos 
                ON procedimentos.id = plano_itens.procedimento_id
            WHERE plano_itens.paciente_id = ?
        ");

        $sql->execute([$paciente_id]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}