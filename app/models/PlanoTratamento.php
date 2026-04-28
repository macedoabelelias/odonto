<?php

require_once BASE_PATH . "/core/Model.php";

class PlanoTratamento extends Model
{

public function criar($dados)
{

$sql = $this->pdo->prepare("
INSERT INTO planos_tratamento
(paciente_id,usuario_id,dente,procedimento,valor,observacoes)
VALUES
(:paciente,:usuario,:dente,:procedimento,:valor,:obs)
");

$sql->bindValue(":paciente",$dados['paciente_id']);
$sql->bindValue(":usuario",$dados['usuario_id']);
$sql->bindValue(":dente",$dados['dente']);
$sql->bindValue(":procedimento",$dados['procedimento']);
$sql->bindValue(":valor",$dados['valor']);
$sql->bindValue(":obs",$dados['observacoes']);

$sql->execute();

}


public function listarPaciente($paciente)
{

$sql = $this->pdo->prepare("
SELECT *
FROM planos_tratamento
WHERE paciente_id = :paciente
ORDER BY data DESC
");

$sql->bindValue(":paciente",$paciente);
$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

}