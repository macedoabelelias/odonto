<?php

require_once BASE_PATH . "/app/models/Consulta.php";
require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Usuario.php";
require_once BASE_PATH . "/app/models/Prontuario.php";

class ConsultasController extends Controller
{

private $consultaModel;

public function __construct()
{
$this->consultaModel = new Consulta();
}

/* ==========================
   LISTAR AGENDA
========================== */

public function index()
{

$modo = $_GET['modo'] ?? 'semana';

$data = $_GET['data'] ?? date('Y-m-d');

$dentista = $_GET['dentista'] ?? null;

/* CONTROLE DE PERMISSÃO */

$nivel = $_SESSION['usuario_nivel'] ?? '';

if($nivel == 'dentista'){

$dentista = $_SESSION['usuario_id'];

}

$usuarioModel = new Usuario();
$dentistas = $usuarioModel->listarDentistas();

/* ESTATÍSTICAS */

$estatisticas = $this->consultaModel->estatisticasHoje($dentista);

/* CONSULTAS */

if($modo == 'dia'){

$consultas = $this->consultaModel->listarPorData($data,$dentista);

}
elseif($modo == 'semana'){

$consultas = $this->consultaModel->listarSemana($data,$dentista);

}
elseif($modo == 'mes'){

$consultas = $this->consultaModel->listarMes($data,$dentista);

}
else{

$consultas = $this->consultaModel->listarPorData($data,$dentista);

}

/* VIEW */

$this->view("consultas/index",[

"consultas"=>$consultas,
"data"=>$data,
"modo"=>$modo,
"dentistas"=>$dentistas,
"dentistaSelecionado"=>$dentista,
"estatisticas"=>$estatisticas

]);

}


/* ==========================
   FORM NOVA CONSULTA
========================== */

public function criar()
{

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$pacientes = $pacienteModel->listarTodos();
$dentistas = $usuarioModel->listarDentistas();

$data = $_GET['data'] ?? null;
$hora = $_GET['hora'] ?? null;
$pacienteSelecionado = $_GET['paciente'] ?? null;

$this->view("consultas/criar",[

"pacientes"=>$pacientes,
"dentistas"=>$dentistas,
"data"=>$data,
"hora"=>$hora,
"pacienteSelecionado"=>$pacienteSelecionado

]);

}


/* ==========================
   SALVAR CONSULTA
========================== */

public function salvar()
{

if($_SERVER['REQUEST_METHOD'] !== 'POST'){

header("Location: " . BASE_URL . "/consultas");
exit;

}

if($this->consultaModel->horarioOcupado(
$_POST['usuario_id'],
$_POST['data'],
$_POST['hora']
)){

$_SESSION['erro'] = "Este dentista já possui consulta neste horário.";

header("Location: " . BASE_URL . "/consultas/criar");
exit;

}

$dados = [

"paciente_id" => $_POST['paciente_id'],
"usuario_id" => $_POST['usuario_id'],
"data" => $_POST['data'],
"hora" => $_POST['hora'],
"procedimento" => $_POST['procedimento'] ?? null,
"observacoes" => $_POST['observacoes'] ?? null

];

$this->consultaModel->salvar($dados);

header("Location: " . BASE_URL . "/consultas?data=" . $dados['data']);
exit;

}


/* ==========================
   EDITAR CONSULTA
========================== */

public function editar($id)
{

$consulta = $this->consultaModel->buscarPorId($id);

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$pacientes = $pacienteModel->listarTodos();
$dentistas = $usuarioModel->listarDentistas();

$this->view("consultas/editar",[

"consulta"=>$consulta,
"pacientes"=>$pacientes,
"dentistas"=>$dentistas

]);

}


/* ==========================
   ATUALIZAR CONSULTA
========================== */

public function atualizar($id)
{

$dados = [

"paciente_id"=>$_POST['paciente_id'],
"usuario_id"=>$_POST['usuario_id'],
"data"=>$_POST['data'],
"hora"=>$_POST['hora'],
"procedimento"=>$_POST['procedimento'],
"observacoes"=>$_POST['observacoes'],
"status"=>$_POST['status']

];

$this->consultaModel->atualizar($id,$dados);

header("Location: ".BASE_URL."/consultas");
exit;

}


/* ==========================
   INICIAR CONSULTA
========================== */

public function iniciar($id)
{

$consulta = $this->consultaModel->buscarPorId($id);

if(!$consulta){

header("Location: ".BASE_URL."/consultas");
exit;

}

/* atualizar status */

$this->consultaModel->atualizarStatus($id,'atendimento');

/* registrar no prontuário */

$prontuarioModel = new Prontuario();
$prontuarioModel->registrarConsulta($consulta);

/* abrir prontuário */

header("Location: ".BASE_URL."/prontuarios/index/".$consulta['paciente_id']);
exit;

}


/* ==========================
   FINALIZAR CONSULTA
========================== */

public function finalizar($id)
{

$this->consultaModel->atualizarStatus($id,'finalizado');

header("Location: " . BASE_URL . "/consultas");
exit;

}


/* ==========================
   ALTERAR STATUS VIA AJAX
========================== */

public function status()
{

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if(!$id || !$status){

echo json_encode(["success"=>false]);
exit;

}

$this->consultaModel->atualizarStatus($id,$status);

echo json_encode(["success"=>true]);
exit;

}


/* ==========================
   MOVER CONSULTA (DRAG)
========================== */

public function mover()
{

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$novaData = $data['data'] ?? null;
$novaHora = $data['hora'] ?? null;

if(!$id){

echo json_encode(["success"=>false]);
exit;

}

$consulta = $this->consultaModel->buscarPorId($id);

if(!$consulta){

echo json_encode(["success"=>false]);
exit;

}

$dados = [

"paciente_id"=>$consulta['paciente_id'],
"usuario_id"=>$consulta['usuario_id'],
"data"=>$novaData,
"hora"=>$novaHora,
"procedimento"=>$consulta['procedimento'],
"observacoes"=>$consulta['observacoes'],
"status"=>$consulta['status']

];

$this->consultaModel->atualizar($id,$dados);

echo json_encode(["success"=>true]);
exit;

}

}