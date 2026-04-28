<?php

require_once BASE_PATH . "/app/models/Anamnese.php";
require_once BASE_PATH . "/app/models/Paciente.php";

/* carregar dompdf */
require_once BASE_PATH . "/vendor/dompdf/vendor/autoload.php";

use Dompdf\Dompdf;

class AnamneseController extends Controller
{

public function index($paciente){

$pacienteModel = new Paciente();
$anamneseModel = new Anamnese();

$paciente = $pacienteModel->buscarPorId($paciente);

$anamnese = $anamneseModel->buscarPorPaciente($paciente['id']);

$this->view("anamnese/index",[

"paciente"=>$paciente,
"anamnese"=>$anamnese

]);

}


public function salvar(){

$model = new Anamnese();

$model->salvar($_POST);

header("Location: ".BASE_URL."/prontuarios/index/".$_POST['paciente_id']);
exit;

}


public function pdf($paciente_id){

$pacienteModel = new Paciente();
$anamneseModel = new Anamnese();

$paciente = $pacienteModel->buscarPorId($paciente_id);
$anamnese = $anamneseModel->buscarPorPaciente($paciente_id);

/* gerar html */

ob_start();

require BASE_PATH . "/app/views/anamnese/pdf.php";

$html = ob_get_clean();

/* gerar pdf */

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4','portrait');

$dompdf->render();

/* abrir no navegador */

$dompdf->stream("anamnese.pdf",["Attachment"=>false]);

}

}