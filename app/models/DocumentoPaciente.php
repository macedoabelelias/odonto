<?php

public function atestado($paciente_id){

require_once BASE_PATH."/app/models/Paciente.php";
require_once BASE_PATH."/app/models/Usuario.php";

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$usuario_id = $_SESSION['usuario_id'];
$dentista = $usuarioModel->buscarPorId($usuario_id);


/* dias de repouso */

$dias = $_GET['dias'] ?? 1;

$data_inicio = new DateTime();

$data_fim = clone $data_inicio;
$data_fim->modify("+".($dias-1)." days");


ob_start();

require BASE_PATH."/app/views/documentos/atestado.php";

$html = ob_get_clean();

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper("A4","portrait");

$dompdf->render();

$dompdf->stream("atestado.pdf",["Attachment"=>false]);

}

?>