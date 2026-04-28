<?php

require_once BASE_PATH . "/core/Model.php";

class Radiografia extends Model
{

    public function salvar($dados)
    {

        $sql = $this->pdo->prepare("
            INSERT INTO radiografias
            (paciente_id, dente, consulta_id, arquivo, descricao)
            VALUES
            (:paciente, :dente, :consulta, :arquivo, :descricao)
        ");

        $sql->bindValue(":paciente", $dados['paciente_id'], PDO::PARAM_INT);
        $sql->bindValue(":dente", $dados['dente'] ?? null);
        $sql->bindValue(":consulta", $dados['consulta_id'] ?? null);
        $sql->bindValue(":arquivo", $dados['arquivo']);
        $sql->bindValue(":descricao", $dados['descricao'] ?? null);

        return $sql->execute();

    }


    public function listarPorPaciente($paciente)
    {

        $sql = $this->pdo->prepare("
            SELECT *
            FROM radiografias
            WHERE paciente_id = :paciente
            ORDER BY data_upload DESC
        ");

        $sql->bindValue(":paciente", $paciente, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }


    public function listarPorDente($paciente, $dente)
    {

        $sql = $this->pdo->prepare("
            SELECT *
            FROM radiografias
            WHERE paciente_id = :paciente
            AND dente = :dente
            ORDER BY data_upload DESC
        ");

        $sql->bindValue(":paciente", $paciente, PDO::PARAM_INT);
        $sql->bindValue(":dente", $dente);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarGerais($paciente)
{

    $sql = $this->pdo->prepare("
        SELECT *
        FROM radiografias
        WHERE paciente_id = :paciente
        AND dente IS NULL
        ORDER BY data_upload DESC
    ");

    $sql->bindValue(":paciente", $paciente, PDO::PARAM_INT);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);

}

public function excluir($id)
{

$sql = $this->pdo->prepare("
DELETE FROM radiografias
WHERE id = :id
");

$sql->bindValue(":id",$id);
$sql->execute();

}


public function dentesComRadiografia($paciente){

$sql = $this->pdo->prepare("
SELECT DISTINCT dente
FROM radiografias
WHERE paciente_id = :paciente
AND dente IS NOT NULL
");

$sql->bindValue(":paciente",$paciente);
$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}



}