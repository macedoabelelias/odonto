<?php

require_once BASE_PATH . "/core/Model.php";

class Prontuario extends Model
{

    /* ==========================
       LISTAR REGISTROS DO PACIENTE
    ========================== */

    public function listarPorPaciente($paciente_id)
    {

        $sql = $this->pdo->prepare("
        SELECT *
        FROM prontuarios_registros
        WHERE paciente_id = ?
        ");

        $sql->execute([$paciente_id]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ==========================
       HISTÓRICO DO DENTE
    ========================== */

    public function getHistoricoDente($paciente_id,$dente)
    {

        $sql = $this->pdo->prepare("
        SELECT procedimento,status,data
        FROM prontuarios_registros

        WHERE paciente_id = ?
        AND dente = ?

        ORDER BY data DESC
        ");

        $sql->execute([$paciente_id,$dente]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }


    /* ==========================
       SALVAR PROCEDIMENTO
    ========================== */

    public function salvarRegistro($dados)
{

$sql = $this->pdo->prepare("

INSERT INTO prontuarios_registros
(paciente_id,dente,procedimento,status,observacoes,data)

VALUES (?,?,?,?,?,NOW())

");

return $sql->execute([

$dados["paciente_id"],
$dados["dente"],
$dados["procedimento"],
$dados["status"],
$dados["observacoes"]

]);

}

    public function buscarRegistroDente($paciente,$dente)
    {

        $sql = $this->pdo->prepare("

        SELECT *
        FROM prontuarios_registros
        WHERE paciente_id=? AND dente=?
        ORDER BY id DESC
        LIMIT 1

        ");

        $sql->execute([$paciente,$dente]);

        return $sql->fetch(PDO::FETCH_ASSOC);

    }


    /* ==========================
       REMOVER PROCEDIMENTOS DO DENTE
    ========================== */

    public function removerPorDente($paciente_id,$dente)
    {

        $sql = $this->pdo->prepare("

        DELETE FROM prontuarios_registros

        WHERE paciente_id = ?
        AND dente = ?

        ");

        return $sql->execute([$paciente_id,$dente]);

    }

}