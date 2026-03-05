<?php

require_once BASE_PATH . "/core/Model.php";

class Prontuario extends Model
{
   public function salvarRegistro($dados)
{
    $sql = $this->pdo->prepare("
        INSERT INTO prontuarios_registros
        (paciente_id, dente, procedimento, status, observacoes)
        VALUES
        (:paciente_id, :dente, :procedimento, :status, :observacoes)
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
        FROM prontuarios_registros
        WHERE paciente_id = :paciente_id
        AND dente = :dente
        ORDER BY data_registro DESC
        ");

        $sql->bindValue(":paciente_id",$paciente_id);
        $sql->bindValue(":dente",$dente);

        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getHistoricoDente($paciente,$dente){

        $sql = "SELECT procedimento,status,
        DATE_FORMAT(created_at,'%d/%m/%Y') as data
        FROM prontuarios_registros
        WHERE paciente_id = :paciente
        AND dente = :dente
        ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":paciente",$paciente);
        $stmt->bindValue(":dente",$dente);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function removerPorDente($paciente,$dente)
    {

        $sql = $this->pdo->prepare("
        DELETE FROM prontuarios_registros
        WHERE paciente_id = :paciente
        AND dente = :dente
        ");

        $sql->bindValue(":paciente",$paciente);
        $sql->bindValue(":dente",$dente);

        $sql->execute();

    }
}