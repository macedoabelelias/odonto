<?php

require_once BASE_PATH . "/app/models/Radiografia.php";

class RadiografiasController extends Controller
{

public function upload()
{

$paciente = $_POST['paciente_id'];
$dente = $_POST['dente'];

if(!isset($_FILES['arquivo'])){

echo json_encode(["status"=>"erro"]);
exit;

}

$arquivo = $_FILES['arquivo'];

$nome = time()."_".$arquivo['name'];

move_uploaded_file(

$arquivo['tmp_name'],
BASE_PATH."/public/uploads/radiografias/".$nome

);

$model = new Radiografia();

$model->salvar([

"paciente_id"=>$paciente,
"dente"=>$dente,
"arquivo"=>$nome

]);

echo json_encode(["status"=>"ok"]);

}

}