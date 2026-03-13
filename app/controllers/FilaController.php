<?php

require_once BASE_PATH."/app/models/FilaAtendimento.php";

class FilaController extends Controller{

public function index(){

$filaModel = new FilaAtendimento();

$aguardando = $filaModel->listarAguardando();

$this->view("fila/index",[

"fila"=>$aguardando

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