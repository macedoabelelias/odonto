<?php

require_once BASE_PATH . "/app/models/Prontuario.php";
require_once BASE_PATH . "/app/models/Paciente.php";

class ProntuariosController extends Controller
{
    public function index($paciente_id)
    {
        $pacienteModel = new Paciente();
        $prontuarioModel = new Prontuario();

        $paciente = $pacienteModel->buscarPorId($paciente_id);
        $registros = $prontuarioModel->listarPorPaciente($paciente_id);

        $this->view("prontuarios/index", [
            "paciente" => $paciente,
            "registros" => $registros
        ]);
    }

    public function salvarRegistro()
    {
        $model = new Prontuario();

        $dados = [
            "paciente_id" => $_POST["paciente_id"],
            "dente" => $_POST["dente"],
            "procedimento" => $_POST["procedimento"],
            "status" => $_POST["status"],
            "observacoes" => $_POST["observacoes"]
        ];

        $model->salvarRegistro($dados);

        echo json_encode(["status" => "ok"]);
        exit;
    }

    public function registros($paciente_id)
    {
        $model = new Prontuario();

        $dados = $model->listarPorPaciente($paciente_id);

        echo json_encode($dados);
        exit;
    }

    public function historico($paciente_id,$dente)
    {

        $model = new Prontuario();

        $dados = $model->getHistoricoDente($paciente_id,$dente);

        echo json_encode($dados);
        exit;

    }

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