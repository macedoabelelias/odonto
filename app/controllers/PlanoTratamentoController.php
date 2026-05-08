<?php

require_once BASE_PATH."/app/models/PlanoTratamento.php";

class PlanoTratamentoController extends Controller
{

public function salvar()
{

$model = new PlanoTratamento();

$dados = [

"paciente_id"=>$_POST['paciente_id'],
"usuario_id"=>$_SESSION['usuario_id'],
"dente"=>$_POST['dente'],
"procedimento"=>$_POST['procedimento'],
"valor"=>$_POST['valor'],
"observacoes"=>$_POST['observacoes']

];

$model->criar($dados);

header("Location: ".BASE_URL."/prontuarios/index/".$dados['paciente_id']);
exit;

}

}