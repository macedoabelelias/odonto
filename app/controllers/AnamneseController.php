<?php

require_once BASE_PATH . "/vendor/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

require_once BASE_PATH . "/app/models/Anamnese.php";
require_once BASE_PATH . "/app/models/Paciente.php";

class AnamneseController extends Controller
{

    public function index($paciente_id = null)
    {

        if(!$paciente_id){
            header("Location: " . BASE_URL . "/pacientes");
            exit;
        }

        $pacienteModel = new Paciente();
        $anamneseModel = new Anamnese();

        $paciente = $pacienteModel->buscarPorId($paciente_id);
        $anamnese = $anamneseModel->buscarPorPaciente($paciente_id);

        $this->view("anamnese/index",[

            "paciente"=>$paciente,
            "anamnese"=>$anamnese

        ]);

    }


    public function salvar($paciente_id = null)
    {

        if(!$paciente_id){
            echo "Paciente não informado";
            exit;
        }

        $model = new Anamnese();

        $dados = [

        "paciente_id" => $paciente_id,

        "diabetes" => $_POST["diabetes"] ?? "nao",
        "hipertensao" => $_POST["hipertensao"] ?? "nao",
        "problema_cardiaco" => $_POST["problema_cardiaco"] ?? "nao",

        "alergias" => $_POST["alergias"] ?? "nao",
        "quais_alergias" => $_POST["quais_alergias"] ?? "",

        "uso_medicamentos" => $_POST["uso_medicamentos"] ?? "nao",
        "quais_medicamentos" => $_POST["quais_medicamentos"] ?? "",

        "observacoes" => $_POST["observacoes"] ?? ""

        ];

        $model->salvar($dados);

        header("Location: ".BASE_URL."prontuarios/index/".$paciente_id);
        exit;

    }


    public function pdf($paciente_id)
    {

        $model = new Anamnese();
        $pacienteModel = new Paciente();

        $anamnese = $model->buscarPorPaciente($paciente_id);
        $paciente = $pacienteModel->buscarPorId($paciente_id);

        ob_start();

        require BASE_PATH . "/app/views/anamnese/pdf.php";

        $html = ob_get_clean();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper("A4", "portrait");

        $dompdf->render();

        $dompdf->stream("anamnese.pdf", ["Attachment"=>false]);

    }

}