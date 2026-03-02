<?php

require_once BASE_PATH . "/app/models/Prontuario.php";
require_once BASE_PATH . "/app/models/Paciente.php";

class ProntuariosController extends Controller
{
   public function index($paciente_id = null)
{
    if(!$paciente_id){
        echo "Paciente não informado.";
        return;
    }

    $prontuarioModel = new Prontuario();
    $pacienteModel   = new Paciente();

    $paciente = $pacienteModel->buscarPorId($paciente_id);
    $prontuarios = $prontuarioModel->listarPorPaciente($paciente_id);

    $this->view("prontuarios/index", [
        'paciente' => $paciente,
        'prontuarios' => $prontuarios
    ]);
}
}