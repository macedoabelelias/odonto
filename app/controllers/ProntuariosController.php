<?php

require_once BASE_PATH . "/app/models/Prontuario.php";
require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Anamnese.php";

class ProntuariosController extends Controller
{

/* ==========================
   ABRIR PRONTUÁRIO
========================== */

public function index($paciente_id = null)
{

if(!$paciente_id){
header("Location: " . BASE_URL . "/pacientes");
exit;
}

$pacienteModel = new Paciente();
$prontuarioModel = new Prontuario();
$anamneseModel = new Anamnese();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$registros = $prontuarioModel->listarPorPaciente($paciente_id);

$anamnese = $anamneseModel->buscarPorPaciente($paciente_id);

$this->view("prontuarios/index",[

"paciente"=>$paciente,
"registros"=>$registros,
"anamnese"=>$anamnese,
"prontuario"=>$prontuarioModel

]);

}


/* ==========================
   SALVAR PROCEDIMENTO
========================== */

public function salvarRegistro()
{

$model = new Prontuario();

$dados = [

"paciente_id"=>$_POST["paciente_id"],
"dente"=>$_POST["dente"],
"procedimento"=>$_POST["procedimento"],
"status"=>$_POST["status"],
"observacoes"=>$_POST["observacoes"]

];

$model->salvarRegistro($dados);

header("Location: ".BASE_URL."prontuarios/index/".$dados["paciente_id"]);
exit;

}


/* ==========================
   LISTAR REGISTROS (AJAX)
========================== */

public function registros($paciente_id)
{

$model = new Prontuario();

$dados = $model->listarPorPaciente($paciente_id);

echo json_encode($dados);
exit;

}


/* ==========================
   HISTÓRICO DO DENTE
========================== */

public function historico($paciente_id,$dente)
{

$model = new Prontuario();

$dados = $model->getHistoricoDente($paciente_id,$dente);

echo json_encode($dados);
exit;

}


/* ==========================
   REMOVER PROCEDIMENTO
========================== */

public function removerRegistro()
{

$model = new Prontuario();

$paciente = $_POST["paciente_id"];
$dente = $_POST["dente"];

$model->removerPorDente($paciente,$dente);

echo json_encode(["status"=>"ok"]);
exit;

}

}