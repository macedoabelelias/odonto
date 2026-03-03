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
            "face" => $_POST["face"],
            "procedimento" => $_POST["procedimento"],
            "observacoes" => $_POST["observacoes"]
        ];

        $model->salvarRegistro($dados);

        echo json_encode(["status" => "ok"]);
        exit;
    }
}