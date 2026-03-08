<?php

require_once BASE_PATH . "/app/models/Prontuario.php";
require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Anamnese.php";

class ProntuariosController extends Controller
{
public function index($paciente_id = null)
{

if(!$paciente_id){
header("Location: " . BASE_URL . "/pacientes");
exit;
}

$pacienteModel = new Paciente();
$prontuarioModel = new Prontuario();
$anamneseModel = new Anamnese();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$registros = $prontuarioModel->listarPorPaciente($paciente_id);

$anamnese = $anamneseModel->buscarPorPaciente($paciente_id);

$this->view("prontuarios/index", [

"paciente"=>$paciente,
"registros"=>$registros,
"anamnese"=>$anamnese

]);

}

   public function salvarRegistro()
    {

        $model = new Prontuario();

        $dados = [

        "paciente_id"=>$_POST["paciente_id"],
        "dente"=>$_POST["dente"],
        "procedimento"=>$_POST["procedimento"],
        "status"=>$_POST["status"],
        "observacoes"=>$_POST["observacoes"]

        ];

        $model->salvarRegistro($dados);

        header("Location: ".BASE_URL."prontuario/paciente/".$_POST["paciente_id"]);

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

    public function salvarProcedimento(){

        $dente = $_POST['dente'];
        $procedimento = $_POST['procedimento'];
        $obs = $_POST['observacoes'];

        $model = new Prontuario();

        $model->salvarProcedimento($dente,$procedimento,$obs);

        header("Location: ".BASE_URL."prontuario");

    }
}