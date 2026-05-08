<?php

require_once BASE_PATH . "/core/Model.php";

class Anamnese extends Model{

public function buscarPorPaciente($paciente){

$sql = $this->pdo->prepare("
SELECT *
FROM anamnese
WHERE paciente_id = :paciente
LIMIT 1
");

$sql->bindValue(":paciente",$paciente);
$sql->execute();

return $sql->fetch(PDO::FETCH_ASSOC);

}


public function salvar($dados){

$sql = $this->pdo->prepare("

INSERT INTO anamnese
(
paciente_id,

diabetes,
hipertensao,
problema_cardiaco,
gravidez,
quantas_semanas,
outras_informacoes,

alergias,
quais_alergias,

uso_medicamentos,
quais_medicamentos,

cirurgias,
quais_cirurgias,

escovacao_dia,
uso_fio_dental,
uso_enxaguante,

dor_dente,
dor_mastigar,
sensibilidade,
sangramento_gengiva,

dor_abrir_boca,
estalo_mandibula,

observacoes
)

VALUES
(
:paciente,

:diabetes,
:hipertensao,
:cardiaco,
:gravidez,
:quantas_semanas,
:outras_informacoes,

:alergias,
:quais_alergias,

:medicamentos,
:quais_medicamentos,

:cirurgias,
:quais_cirurgias,

:escovacao,
:fio,
:enxaguante,

:dor_dente,
:dor_mastigar,
:sensibilidade,
:sangramento,

:dor_boca,
:estalo,

:observacoes
)

");

$sql->bindValue(":paciente",$dados['paciente_id']);

$sql->bindValue(":diabetes",$dados['diabetes']);
$sql->bindValue(":hipertensao",$dados['hipertensao']);
$sql->bindValue(":cardiaco",$dados['problema_cardiaco']);

$sql->bindValue(":gravidez",$dados['gravidez']);
$sql->bindValue(":quantas_semanas",$dados['quantas_semanas']);
$sql->bindValue(":outras_informacoes",$dados['outras_informacoes']);

$sql->bindValue(":alergias",$dados['alergias']);
$sql->bindValue(":quais_alergias",$dados['quais_alergias']);

$sql->bindValue(":medicamentos",$dados['uso_medicamentos']);
$sql->bindValue(":quais_medicamentos",$dados['quais_medicamentos']);

$sql->bindValue(":cirurgias",$dados['cirurgias']);
$sql->bindValue(":quais_cirurgias",$dados['quais_cirurgias']);

$sql->bindValue(":escovacao",$dados['escovacao_dia']);
$sql->bindValue(":fio",$dados['uso_fio_dental']);
$sql->bindValue(":enxaguante",$dados['uso_enxaguante']);

$sql->bindValue(":dor_dente",$dados['dor_dente']);
$sql->bindValue(":dor_mastigar",$dados['dor_mastigar']);
$sql->bindValue(":sensibilidade",$dados['sensibilidade']);
$sql->bindValue(":sangramento",$dados['sangramento_gengiva']);

$sql->bindValue(":dor_boca",$dados['dor_abrir_boca']);
$sql->bindValue(":estalo",$dados['estalo_mandibula']);

$sql->bindValue(":observacoes",$dados['observacoes']);

return $sql->execute();

}

}