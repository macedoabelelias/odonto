<?php

require_once BASE_PATH . "/app/models/Radiografia.php";

class RadiografiasController extends Controller
{

    public function upload()
    {

        header("Content-Type: application/json");

        if(empty($_POST['paciente_id'])){
            echo json_encode(["status"=>"erro","msg"=>"Paciente não informado"]);
            exit;
        }

        $paciente = $_POST['paciente_id'];
        $dente = $_POST['dente'] ?? null;

        if(!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] != 0){

            echo json_encode(["status"=>"erro","msg"=>"Arquivo não enviado"]);
            exit;

        }

        $arquivo = $_FILES['arquivo'];

        $nome = time()."_".$arquivo['name'];

        $destino = BASE_PATH."/public/uploads/radiografias/".$nome;

        if(!move_uploaded_file($arquivo['tmp_name'], $destino)){

            echo json_encode(["status"=>"erro","msg"=>"Falha no upload"]);
            exit;

        }

        $model = new Radiografia();

        $model->salvar([

            "paciente_id"=>$paciente,
            "dente"=>$dente,
            "consulta_id"=>null,
            "arquivo"=>$nome,
            "descricao"=>null

        ]);

        echo json_encode(["status"=>"ok","arquivo"=>$nome]);

    }

    public function excluir()
{

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if(!$id){

echo json_encode(["status"=>"erro"]);
exit;

}

$model = new Radiografia();

$model->excluir($id);

echo json_encode(["status"=>"ok"]);

exit;

}

public function porDente()
{

header('Content-Type: application/json');

$paciente = $_GET['paciente'] ?? null;
$dente = $_GET['dente'] ?? null;

if(!$paciente || !$dente){

echo json_encode([]);
exit;

}

$model = new Radiografia();

$dados = $model->listarPorDente($paciente,$dente);

echo json_encode($dados);

exit;

}

public function dentesComRadiografia(){

header('Content-Type: application/json');

$paciente = $_GET['paciente'] ?? null;

$model = new Radiografia();

$dados = $model->dentesComRadiografia($paciente);

echo json_encode($dados);
exit;

}

}