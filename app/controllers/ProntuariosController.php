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

$nivel = $_SESSION['usuario_nivel'] ?? '';
$usuario_id = $_SESSION['usuario_id'] ?? null;

/* BLOQUEAR RECEPÇÃO */

if($nivel == 'recepcionista' || $nivel == 'recepcao'){

header("Location: ".BASE_URL."/pacientes");
exit;

}

if(!$paciente_id){

header("Location: " . BASE_URL . "/pacientes");
exit;

}

$pacienteModel = new Paciente();
$prontuarioModel = new Prontuario();

$paciente = $pacienteModel->buscarPorId($paciente_id);

/* DENTISTA SÓ PODE VER PACIENTES DELE */

if($nivel == 'dentista'){

if($paciente['usuario_id'] != $usuario_id){

header("Location: ".BASE_URL."/pacientes");
exit;

}

}

$registros = $prontuarioModel->buscarRegistrosPaciente($paciente_id);


$this->view("prontuarios/index",[

"paciente"=>$paciente,
"registros"=>$registros

]);

}


/* ==========================
   SALVAR PROCEDIMENTO
========================== */

public function salvarRegistro()
{

$paciente = $_POST['paciente_id'] ?? null;
$dente = $_POST['dente'] ?? null;
$procedimento = $_POST['procedimento'] ?? null;
$status = $_POST['status'] ?? 'planejado';
$observacoes = $_POST['observacoes'] ?? null;
$face = $_POST['face'] ?? '';


$usuario = $_SESSION['usuario_id'] ?? null;

$sql = $this->pdo->prepare("
INSERT INTO prontuarios_registros
(
paciente_id,
usuario_id,
dente,
procedimento,
status,
observacoes,
tipo,
data
)
VALUES
(
:paciente,
:usuario,
:dente,
:procedimento,
:status,
:obs,
'odontograma',
NOW()
)
");

$sql->bindValue(":paciente",$paciente);
$sql->bindValue(":usuario",$usuario);
$sql->bindValue(":dente",$dente);
$sql->bindValue(":procedimento",$procedimento);
$sql->bindValue(":status",$status);
$sql->bindValue(":obs",$observacoes);

$sql->execute();

echo json_encode(["status"=>"ok"]);

}


/* ==========================
   LISTAR REGISTROS (AJAX)
========================== */

public function registros($paciente_id)
{

$prontuario = new Prontuario();

$dados = $prontuario->listarRegistrosPaciente($paciente_id);

header("Content-Type: application/json");

echo json_encode($dados);

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