<?php

require_once BASE_PATH . "/app/models/Consulta.php";
require_once BASE_PATH . "/app/models/Paciente.php";

class DashboardController extends Controller {

public function index()
{

$consultaModel = new Consulta();
$pacienteModel = new Paciente();

$dataHoje = date('Y-m-d');

$consultasHoje = $consultaModel->listarPorData($dataHoje);

$pacientes = $pacienteModel->listarTodos();
$totalPacientes = count($pacientes);

$this->view("dashboard/index",[

"consultasHoje"=>$consultasHoje,
"pacientes"=>$totalPacientes,
"atendidosHoje"=>0,
"faturamentoHoje"=>0,
"aniversariantes"=>[],
"recebido"=>0,
"pago"=>0,
"compras"=>0,
"estoqueBaixo"=>[],
"labels"=>[],
"receitas"=>[],
"despesas"=>[]

]);

}
}