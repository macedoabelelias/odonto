<?php

require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Financeiro.php";

class DashboardController extends Controller
{

    public function index()
    {

        $pacienteModel = new Paciente();
        $financeiroModel = new Financeiro();

        $dataHoje = date('Y-m-d');

        $consultasHoje = 0;
        $atendidosHoje = 0;
        $agendaHoje = [];

        $aniversariantes = $pacienteModel->aniversariantesHoje();

        $contasReceberHoje = $financeiroModel->contasReceberHoje($dataHoje);
        $recebidoHoje = $financeiroModel->recebidoHoje($dataHoje);
        $totalAberto = $financeiroModel->totalEmAberto();

        $dados = [

            "consultasHoje"=>$consultasHoje,
            "atendidosHoje"=>$atendidosHoje,
            "agendaHoje"=>$agendaHoje,
            "aniversariantes"=>$aniversariantes,

            "contasReceberHoje"=>$contasReceberHoje,
            "recebidoHoje"=>$recebidoHoje,
            "totalAberto"=>$totalAberto

        ];

        $this->view("dashboard/index",$dados);

    }

}