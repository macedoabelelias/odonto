<?php

require_once BASE_PATH . "/app/models/Paciente.php";

class PacientesController extends Controller {

    public function index() {

        require_once BASE_PATH . "/config/autenticarpainel.php";

        $pacienteModel = new Paciente();
        $pacientes = $pacienteModel->listar();

        $this->view("pacientes/index", [
            'pacientes' => $pacientes,
            'nivel' => $_SESSION['usuario_nivel'] ?? ''
        ]);
    }

    public function criar() {
        require_once BASE_PATH . "/config/autenticarpainel.php";
        $this->view("pacientes/criar");
    }

    public function salvar() {

        $pacienteModel = new Paciente();
        $pacienteModel->salvar($_POST);

        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }

    public function excluir($id) {

        $pacienteModel = new Paciente();
        $pacienteModel->excluir($id);

        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }

    public function editar($id)
    {
        $pacienteModel = new Paciente();
        $paciente = $pacienteModel->buscarPorId($id);

        $this->view("pacientes/editar", [
            'paciente' => $paciente
        ]);
    }

    public function atualizar($id)
    {
        $pacienteModel = new Paciente();
        $pacienteModel->atualizar($id, $_POST);

        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }
}