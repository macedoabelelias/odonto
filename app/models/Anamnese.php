<?php

require_once BASE_PATH . "/core/Model.php";

class Anamnese extends Model
{

    public function buscarPorPaciente($paciente_id)
    {

        $sql = $this->pdo->prepare("SELECT * FROM anamneses WHERE paciente_id = :paciente");
        $sql->bindValue(":paciente",$paciente_id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }


public function salvar($dados)
{

$sql = $this->pdo->prepare("

INSERT INTO anamneses (

paciente_id,
diabetes,
hipertensao,
problema_cardiaco,
marcapasso,
radioterapia,
gravida,

alergias,
quais_alergias,
uso_medicamentos,
quais_medicamentos,
anticoagulante,

cirurgias,
quais_cirurgias,
sangramento_excessivo,

fuma,
alcool,
roer_unhas,
morder_objetos,

escovacoes_dia,
usa_fio_dental,
sangramento_gengiva,
mau_halito,
sensibilidade,

bruxismo,
barulho_atm,
dor_atm,
dificuldade_abrir_boca,

ultima_consulta,
dor_recente,
nivel_ansiedade,

observacoes

)

VALUES (?,?,?,?,?,?,?,
?,?,?,?,?,
?,?,?,?,?,
?,?,?,?,?,
?,?,?,?,?,
?,?,?,?,?,
?,?,?,
?)

");

return $sql->execute([

$dados["paciente_id"],

$dados["diabetes"],
$dados["hipertensao"],
$dados["problema_cardiaco"],
$dados["marcapasso"],
$dados["radioterapia"],
$dados["gravida"],

$dados["alergias"],
$dados["quais_alergias"],
$dados["uso_medicamentos"],
$dados["quais_medicamentos"],
$dados["anticoagulante"],

$dados["cirurgias"],
$dados["quais_cirurgias"],
$dados["sangramento_excessivo"],

$dados["fuma"],
$dados["alcool"],
$dados["roer_unhas"],
$dados["morder_objetos"],

$dados["escovacoes_dia"],
$dados["usa_fio_dental"],
$dados["sangramento_gengiva"],
$dados["mau_halito"],
$dados["sensibilidade"],

$dados["bruxismo"],
$dados["barulho_atm"],
$dados["dor_atm"],
$dados["dificuldade_abrir_boca"],

$dados["ultima_consulta"],
$dados["dor_recente"],
$dados["nivel_ansiedade"],

$dados["observacoes"]

]);

}

}