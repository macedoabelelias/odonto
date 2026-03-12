<?php

require_once BASE_PATH . "/core/Model.php";

class Radiografia extends Model
{

public function salvar($dados)
{

$sql = $this->pdo->prepare("

INSERT INTO radiografias
(paciente_id,dente,arquivo)

VALUES
(:paciente,:dente,:arquivo)

");

$sql->bindValue(":paciente",$dados['paciente_id']);
$sql->bindValue(":dente",$dados['dente']);
$sql->bindValue(":arquivo",$dados['arquivo']);

return $sql->execute();

}

public function listarPorPaciente($paciente)
{

$sql = $this->pdo->prepare("

SELECT *
FROM radiografias
WHERE paciente_id = :paciente
ORDER BY data DESC

");

$sql->bindValue(":paciente",$paciente);
$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

public function listarPorDente($paciente,$dente)
{

$sql = $this->pdo->prepare("

SELECT *
FROM radiografias
WHERE paciente_id = :paciente
AND dente = :dente
ORDER BY data DESC

");

$sql->bindValue(":paciente",$paciente);
$sql->bindValue(":dente",$dente);
$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

}