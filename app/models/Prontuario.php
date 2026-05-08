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

    // 🔥 PEGA ÚLTIMO ORÇAMENTO ATIVO
    $sqlOrc = $this->pdo->prepare("
        SELECT id
        FROM orcamentos
        WHERE paciente_id = :paciente
        AND status IN ('pendente','aprovado')
        ORDER BY id DESC
        LIMIT 1
    ");

    $sqlOrc->bindValue(':paciente', $paciente);
    $sqlOrc->execute();

    $orcamento = $sqlOrc->fetch(PDO::FETCH_ASSOC);

    $orcamento_id = $orcamento['id'] ?? 0;

    // 🔥 SOMENTE O QUE DEVE APARECER NO ODONTOGRAMA
    $sql = $this->pdo->prepare("

        -- 🔥 ITENS DO ORÇAMENTO ATUAL
        SELECT
            oi.id,
            oi.dente,
            NULL as face,
            oi.procedimento,
            oi.status,
            p.icone
        FROM orcamentos_itens oi
        LEFT JOIN procedimentos p 
            ON p.nome = oi.procedimento
        WHERE oi.orcamento_id = :orcamento_id

        UNION

        -- 🔥 PROCEDIMENTOS AVULSOS
        SELECT
            pp.id,
            pp.dente,
            NULL as face,
            p.nome as procedimento,
            pp.status,
            p.icone
        FROM prontuario_procedimentos pp
        LEFT JOIN procedimentos p 
            ON p.id = pp.procedimento_id
        WHERE pp.paciente_id = :paciente

    ");

    $sql->bindValue(':orcamento_id', $orcamento_id);
    $sql->bindValue(':paciente', $paciente);

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
    try {

        // 🔍 VERIFICA SE JÁ EXISTE
        $check = $this->pdo->prepare("
            SELECT id
            FROM prontuarios_plano
            WHERE paciente_id = :paciente
            LIMIT 1
        ");

        $check->bindValue(":paciente", $paciente);
        $check->execute();

        // =========================================
        // 🔥 UPDATE
        // =========================================

        if($check->rowCount() > 0){

            $sql = $this->pdo->prepare("
                UPDATE prontuarios_plano
                SET
                    descricao = :descricao,
                    usuario_id = :usuario,
                    data = NOW()
                WHERE paciente_id = :paciente
            ");

        // =========================================
        // 🔥 INSERT
        // =========================================

        } else {

            $sql = $this->pdo->prepare("
                INSERT INTO prontuarios_plano
                (
                    paciente_id,
                    usuario_id,
                    descricao,
                    data
                )
                VALUES
                (
                    :paciente,
                    :usuario,
                    :descricao,
                    NOW()
                )
            ");
        }

        $sql->bindValue(":paciente", $paciente);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":descricao", $descricao);

        return $sql->execute();

    } catch(PDOException $e){

        error_log($e->getMessage());

        return false;
    }
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