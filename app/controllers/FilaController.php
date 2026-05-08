<?php

require_once BASE_PATH."/app/models/FilaAtendimento.php";

class FilaController extends Controller{

public function index(){

    $model = new ContaReceber();

    $contas = $model->listar();
    $resumo = $model->resumoFinanceiro();

    $this->view('financeiro/index', [
        'contas' => $contas,
        'resumo' => $resumo
    ]);
}

public function chamar($id){

$model = new FilaAtendimento();

$model->chamarPaciente($id);

header("Location: ".BASE_URL."/fila");

}

public function finalizar($id){

$model = new FilaAtendimento();

$model->finalizar($id);

header("Location: ".BASE_URL."/fila");

}

}