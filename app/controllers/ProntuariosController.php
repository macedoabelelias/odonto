<?php

require_once BASE_PATH . "/app/models/Prontuario.php";
require_once BASE_PATH . "/app/models/Paciente.php";

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

$paciente = $pacienteModel->buscarPorId($paciente_id);

$registros = $prontuarioModel->listarPorPaciente($paciente_id);

$this->view("prontuarios/index",[

"paciente"=>$paciente,
"registros"=>$registros,
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

echo json_encode(["status"=>"ok"]);
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

public function historicoDente()
{

$data = json_decode(file_get_contents("php://input"),true);

$paciente = $data['paciente'];
$dente = $data['dente'];

$model = new Prontuario();

$historico = $model->historicoDente($paciente,$dente);

echo json_encode($historico);
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

public function historicoPaciente($paciente_id)
{

$sql = $this->pdo->prepare("

SELECT *

FROM prontuario_registros

WHERE paciente_id = :paciente

ORDER BY data DESC

");

$sql->bindValue(":paciente",$paciente_id);

$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

}