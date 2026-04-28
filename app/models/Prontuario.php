<?php

require_once BASE_PATH . "/app/models/Consulta.php";
require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Usuario.php";

class Prontuario extends Model {


/* ==========================
   HISTÓRICO DO DENTE
========================== */

public function historicoDente($paciente_id,$dente)
{

$sql = $this->pdo->prepare("
SELECT *
FROM prontuarios_registros
WHERE paciente_id = :paciente
AND dente = :dente
ORDER BY data DESC
");

$sql->bindValue(":paciente",$paciente_id);
$sql->bindValue(":dente",$dente);

$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}


/* ==========================
   REGISTROS DO PACIENTE
========================== */

public function buscarRegistrosPaciente($paciente)
{

    $sql = $this->pdo->prepare("

    SELECT 
        dente,
        face,
        procedimento,
        status
    FROM prontuarios_registros
    WHERE paciente_id = :paciente

    UNION ALL

    SELECT 
        pp.dente,
        NULL as face,
        p.nome as procedimento,
        pp.status
    FROM prontuario_procedimentos pp
    LEFT JOIN procedimentos p ON p.id = pp.procedimento_id
    WHERE pp.paciente_id = :paciente

    ");

    $sql->bindValue(":paciente",$paciente);

    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);

}


/* ==========================
   SALVAR PROCEDIMENTO
========================== */

public function salvarRegistro($dados)
{

$sql = $this->pdo->prepare("
INSERT INTO prontuarios_registros
(
paciente_id,
usuario_id,
tipo,
dente,
face,
procedimento,
status,
observacoes,
data
)
VALUES
(
:paciente_id,
:usuario_id,
:tipo,
:dente,
:face,
:procedimento,
:status,
:observacoes,
NOW()
)
");

$sql->bindValue(":paciente_id",$dados["paciente_id"]);
$sql->bindValue(":usuario_id",$dados["usuario_id"]);
$sql->bindValue(":tipo",$dados["tipo"]);
$sql->bindValue(":dente",$dados["dente"]);
$sql->bindValue(":face",$dados["face"]);
$sql->bindValue(":procedimento",$dados["procedimento"]);
$sql->bindValue(":status",$dados["status"]);
$sql->bindValue(":observacoes",$dados["observacoes"]);

return $sql->execute();

}

/* ==========================
   REMOVER PROCEDIMENTO
========================== */

public function removerPorDente($paciente_id,$dente)
{

$sql = $this->pdo->prepare("
// DELETE FROM prontuarios_registros
// WHERE paciente_id = ?
// AND dente = ?
// ");

return $sql->execute([$paciente_id,$dente]);

}


/* ==========================
   REGISTRAR CONSULTA
========================== */

public function registrarConsulta($consulta)
{

$sql = $this->pdo->prepare("
INSERT INTO prontuarios_registros
(
paciente_id,
usuario_id,
consulta_id,
procedimento,
status,
observacoes,
data,
tipo
)
VALUES
(
:paciente,
:usuario,
:consulta,
:procedimento,
:status,
:obs,
:data,
'consulta'
)
");

$sql->bindValue(":paciente",$consulta['paciente_id']);
$sql->bindValue(":usuario",$consulta['usuario_id']);
$sql->bindValue(":consulta",$consulta['id']);
$sql->bindValue(":procedimento",$consulta['procedimento']);
$sql->bindValue(":status",'atendimento');
$sql->bindValue(":obs",'Consulta iniciada pela agenda');
$sql->bindValue(":data",$consulta['data'].' '.$consulta['hora']);

$sql->execute();

}


/* ==========================
   PROCEDIMENTO GERAL
========================== */

public function salvarProcedimentoGeral($paciente,$procedimento)
{

$usuario = $_SESSION['usuario_id'] ?? null;

$sql = $this->pdo->prepare("
INSERT INTO prontuarios
(paciente_id, usuario_id, data_atendimento, tipo_denticao, procedimento, observacoes)
VALUES
(:paciente, :usuario, CURDATE(), 'geral', :procedimento, '')
");

$sql->bindValue(":paciente",$paciente);
$sql->bindValue(":usuario",$usuario);
$sql->bindValue(":procedimento",$procedimento);

$sql->execute();

}


/* ==========================
   TIMELINE CLÍNICA
========================== */

public function timelinePaciente($paciente)
{

$sql = $this->pdo->prepare("

SELECT 
data,
procedimento,
dente
FROM prontuarios_registros
WHERE paciente_id = :paciente

UNION ALL

SELECT
data_atendimento AS data,
procedimento,
NULL AS dente
FROM prontuarios
WHERE paciente_id = :paciente

ORDER BY data DESC

");

$sql->bindValue(":paciente",$paciente);

$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

/* ==========================
   SALVAR EVOLUÇÃO CLÍNICA
========================== */

public function salvarEvolucao($paciente,$usuario,$descricao)
{

$sql = $this->pdo->prepare("
INSERT INTO prontuarios_evolucao
(paciente_id,usuario_id,descricao,data)
VALUES
(:paciente,:usuario,:descricao,NOW())
");

$sql->bindValue(":paciente",$paciente);
$sql->bindValue(":usuario",$usuario);
$sql->bindValue(":descricao",$descricao);

return $sql->execute();

}


/* ==========================
   SALVAR PLANO TRATAMENTO
========================== */

public function salvarPlano($paciente, $usuario, $descricao)
{
    // 🔍 Verifica se já existe plano
    $check = $this->pdo->prepare("
        SELECT id FROM prontuarios_plano 
        WHERE paciente_id = :paciente
    ");
    $check->bindValue(":paciente", $paciente);
    $check->execute();

    if($check->rowCount() > 0){

        // 🔥 UPDATE
        $sql = $this->pdo->prepare("
            UPDATE prontuarios_plano
            SET descricao = :descricao,
                usuario_id = :usuario,
                data = NOW()
            WHERE paciente_id = :paciente
        ");

    } else {

        // 🔥 INSERT
        $sql = $this->pdo->prepare("
            INSERT INTO prontuarios_plano
            (paciente_id, usuario_id, descricao, data)
            VALUES
            (:paciente, :usuario, :descricao, NOW())
        ");
    }

    $sql->bindValue(":paciente", $paciente);
    $sql->bindValue(":usuario", $usuario);
    $sql->bindValue(":descricao", $descricao);

    return $sql->execute();
}

/* ==========================
   REGISTRAR CONSULTA
========================== */

public function registrarConsultaAgenda($consulta)
{

$sql = $this->pdo->prepare("
INSERT INTO prontuarios_registros
(
paciente_id,
usuario_id,
consulta_id,
procedimento,
status,
observacoes,
data,
tipo
)
VALUES
(
:paciente,
:usuario,
:consulta,
'Consulta',
'agendada',
'Consulta registrada pela agenda',
:data,
'consulta'
)
");

$sql->bindValue(":paciente",$consulta['paciente_id']);
$sql->bindValue(":usuario",$consulta['usuario_id']);
$sql->bindValue(":consulta",$consulta['id']);
$sql->bindValue(":data",$consulta['data'].' '.$consulta['hora']);

$sql->execute();

}

public function buscarPlano($paciente){
    $sql = $this->pdo->prepare("
        SELECT descricao FROM prontuarios_plano
        WHERE paciente_id = :paciente
        LIMIT 1
    ");
    $sql->bindValue(":paciente", $paciente);
    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC);
}

public function buscarEvolucao($paciente_id){

    $sql = $this->pdo->prepare("
        SELECT * FROM prontuarios_evolucao
        WHERE paciente_id = :paciente_id
        ORDER BY data DESC
    ");

    $sql->bindValue(":paciente_id", $paciente_id);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

}