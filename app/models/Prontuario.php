<?php

require_once BASE_PATH . "/core/Model.php";

class Prontuario extends Model
{

/* ==========================
   HISTÓRICO DO PACIENTE
========================== */

public function historicoPaciente($paciente_id)
{

$sql = $this->pdo->prepare("
SELECT *
FROM prontuarios_registros
WHERE paciente_id = :paciente
ORDER BY data DESC
");

$sql->bindValue(":paciente",$paciente_id);
$sql->execute();

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
   LISTAR REGISTROS DO PACIENTE
========================== */

public function listarPorPaciente($paciente_id)
{

$sql = $this->pdo->prepare("

SELECT *
FROM prontuarios_registros
WHERE paciente_id = :paciente
ORDER BY data DESC

");

$sql->bindValue(":paciente",$paciente_id);

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


/* ==========================
   BUSCAR REGISTRO DO DENTE
========================== */

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
   REMOVER PROCEDIMENTO
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
   LISTAR REGISTROS DO PACIENTE
========================== */

public function listarRegistrosPaciente($paciente_id)
{

$sql = $this->pdo->prepare("
SELECT 
prontuarios_registros.*,
usuarios.nome AS dentista
FROM prontuarios_registros
LEFT JOIN usuarios
ON usuarios.id = prontuarios_registros.usuario_id
WHERE paciente_id = :paciente
ORDER BY data DESC
");

$sql->bindValue(":paciente",$paciente_id);
$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}


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

}