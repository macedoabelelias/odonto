<?php

require_once BASE_PATH . "/app/models/EvolucaoClinica.php";

class EvolucaoController extends Controller
{
    public function salvar()
    {
        $model = new EvolucaoClinica();

        $model->salvar([
            'paciente_id' => $_POST['paciente_id'],
            'procedimento_id' => $_POST['procedimento_id'],
            'status' => $_POST['status'],
            'observacao' => $_POST['observacao'] ?? null
        ]);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function atualizarStatus()
    {
        $model = new EvolucaoClinica();

        $model->atualizarStatus(
            $_POST['id'],
            $_POST['status']
        );

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}