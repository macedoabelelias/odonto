<?php

require_once BASE_PATH . "/core/Model.php";

class Prontuario extends Model
{
    public function salvarRegistro($dados)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO prontuarios_registros
            (paciente_id, dente, face, procedimento, observacoes)
            VALUES
            (:paciente_id, :dente, :face, :procedimento, :observacoes)
        ");

        return $sql->execute($dados);
    }

    public function listarPorPaciente($paciente_id)
    {
        $sql = $this->pdo->prepare("
            SELECT * FROM prontuarios_registros
            WHERE paciente_id = :paciente_id
            ORDER BY data_registro DESC
        ");

        $sql->bindValue(":paciente_id", $paciente_id);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function historicoPorDente($paciente_id, $dente)
    {

        $sql = $this->db->prepare("
        SELECT procedimento, face, observacoes, data_registro
        FROM prontuarios
        WHERE paciente_id = :paciente_id
        AND dente = :dente
        ORDER BY data_registro DESC
        ");

        $sql->bindValue(":paciente_id",$paciente_id);
        $sql->bindValue(":dente",$dente);

        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }
}