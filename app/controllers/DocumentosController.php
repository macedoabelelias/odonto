<?php

require_once BASE_PATH."/app/models/Paciente.php";
require_once BASE_PATH."/app/models/Usuario.php";
require_once BASE_PATH."/vendor/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

class DocumentosController extends Controller
{

/* =============================
   FORMULÁRIO DA RECEITA
============================= */

public function receita_form($paciente_id){

$pacienteModel = new Paciente();
$paciente = $pacienteModel->buscarPorId($paciente_id);

$this->view("documentos/receita_form",[
"paciente"=>$paciente
]);

}

/* =============================
   GERAR RECEITA
============================= */

public function receita($paciente_id){

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$usuario_id = $_SESSION['usuario_id'] ?? null;
$dentista = $usuarioModel->buscar($usuario_id);

/* DADOS */
$medicamento = $_POST['medicamento'] ?? '';
$posologia = $_POST['posologia'] ?? '';
$duracao = $_POST['duracao'] ?? '';
$observacao = $_POST['observacao'] ?? '';

/* DESCRIÇÃO */
$descricao = "
Medicamento: $medicamento
Posologia: $posologia
Duração: $duracao
Observações: $observacao
";

/* ARQUIVO */
$nomeArquivo = "receita_".time().".pdf";
$caminho = "uploads/documentos/receitas/".$nomeArquivo;
$diretorio = BASE_PATH."/public/uploads/documentos/receitas/";

if(!is_dir($diretorio)){
    mkdir($diretorio,0777,true);
}

/* HTML */
ob_start();
require BASE_PATH."/app/views/documentos/receita.php";
$html = ob_get_clean();

/* PDF */
$options = new \Dompdf\Options();
$options->set("isRemoteEnabled", true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4","portrait");
$dompdf->render();

/* SALVAR */
file_put_contents(BASE_PATH."/public/".$caminho,$dompdf->output());

$this->salvarDocumento(
$paciente_id,
$usuario_id,
"receita",
$nomeArquivo,
$caminho,
$descricao
);

/* EXIBIR */
$dompdf->stream($nomeArquivo,["Attachment"=>false]);

}

/* =============================
   FORMULÁRIO DO ATESTADO
============================= */

public function atestado_form($paciente_id){

$pacienteModel = new Paciente();
$paciente = $pacienteModel->buscarPorId($paciente_id);

$this->view("documentos/atestado_form",[
"paciente"=>$paciente
]);

}

/* =============================
   GERAR ATESTADO
============================= */

public function atestado($paciente_id){

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$usuario_id = $_SESSION['usuario_id'] ?? null;
$dentista = $usuarioModel->buscar($usuario_id);

$dias = $_GET['dias'] ?? 1;
$cid = $_GET['cid'] ?? '';

$data_inicio = new DateTime();
$data_fim = clone $data_inicio;
$data_fim->modify("+".($dias - 1)." days");

/* DESCRIÇÃO */
$descricao = "
Dias: $dias
CID: $cid
Início: ".$data_inicio->format("d/m/Y")."
Fim: ".$data_fim->format("d/m/Y")."
";

/* ARQUIVO */
$nomeArquivo = "atestado_".time().".pdf";
$caminho = "uploads/documentos/atestados/".$nomeArquivo;
$diretorio = BASE_PATH."/public/uploads/documentos/atestados/";

if(!is_dir($diretorio)){
    mkdir($diretorio,0777,true);
}

/* HTML */
ob_start();
require BASE_PATH."/app/views/documentos/atestado.php";
$html = ob_get_clean();

/* PDF */
$options = new \Dompdf\Options();
$options->set("isRemoteEnabled", true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4","portrait");
$dompdf->render();

/* SALVAR */
file_put_contents(BASE_PATH."/public/".$caminho,$dompdf->output());

$this->salvarDocumento(
$paciente_id,
$usuario_id,
"atestado",
$nomeArquivo,
$caminho,
$descricao
);

/* EXIBIR */
$dompdf->stream($nomeArquivo,["Attachment"=>false]);

}

/* =============================
   FORMULÁRIO DE ENCAMINHAMENTO
============================= */

public function encaminhamento_form($paciente_id){

$pacienteModel = new Paciente();
$paciente = $pacienteModel->buscarPorId($paciente_id);

$this->view("documentos/encaminhamento_form",[
"paciente"=>$paciente
]);

}

/* =============================
   GERAR ENCAMINHAMENTO
============================= */

public function encaminhamento($paciente_id){

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$usuario_id = $_SESSION['usuario_id'] ?? null;
$dentista = $usuarioModel->buscar($usuario_id);

/* DADOS */
$destino = $_POST['destino'] ?? '';
$especialista = $_POST['especialista'] ?? '';
$clinica = $_POST['clinica'] ?? '';
$motivo = $_POST['motivo'] ?? '';
$observacoes = $_POST['observacoes'] ?? '';

/* DESCRIÇÃO */
$descricao = "
Especialidade: $destino
Especialista: $especialista
Clínica: $clinica
Motivo: $motivo
Observações: $observacoes
";

/* ARQUIVO */
$nomeArquivo = "encaminhamento_".time().".pdf";
$caminho = "uploads/documentos/encaminhamentos/".$nomeArquivo;
$diretorio = BASE_PATH."/public/uploads/documentos/encaminhamentos/";

if(!is_dir($diretorio)){
    mkdir($diretorio,0777,true);
}

/* HTML */
ob_start();
require BASE_PATH."/app/views/documentos/encaminhamento.php";
$html = ob_get_clean();

/* PDF */
$options = new \Dompdf\Options();
$options->set("isRemoteEnabled", true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4","portrait");
$dompdf->render();

/* SALVAR */
file_put_contents(BASE_PATH."/public/".$caminho,$dompdf->output());

$this->salvarDocumento(
$paciente_id,
$usuario_id,
"encaminhamento",
$nomeArquivo,
$caminho,
$descricao
);

/* EXIBIR */
$dompdf->stream($nomeArquivo,["Attachment"=>false]);

}

/* =============================
   FORMULÁRIO DE CONSENTIMENTO
============================= */

public function consentimento_form($paciente_id){

$pacienteModel = new Paciente();
$paciente = $pacienteModel->buscarPorId($paciente_id);

$this->view("documentos/consentimento_form",[
"paciente"=>$paciente
]);

}

/* =============================
   GERAR CONSENTIMENTO
============================= */

public function consentimento($paciente_id){

$pacienteModel = new Paciente();
$usuarioModel = new Usuario();

$paciente = $pacienteModel->buscarPorId($paciente_id);

$usuario_id = $_SESSION['usuario_id'] ?? null;
$dentista = $usuarioModel->buscar($usuario_id);

$procedimento = $_POST['procedimento'] ?? '';
$observacoes = $_POST['observacoes'] ?? '';

/* DESCRIÇÃO */
$descricao = "
Procedimento: $procedimento
Observações: $observacoes
";

/* ARQUIVO */
$nomeArquivo = "consentimento_".time().".pdf";
$caminho = "uploads/documentos/consentimentos/".$nomeArquivo;
$diretorio = BASE_PATH."/public/uploads/documentos/consentimentos/";

if(!is_dir($diretorio)){
    mkdir($diretorio,0777,true);
}

/* HTML */
ob_start();
require BASE_PATH."/app/views/documentos/consentimento.php";
$html = ob_get_clean();

/* PDF */
$options = new \Dompdf\Options();
$options->set("isRemoteEnabled", true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4","portrait");
$dompdf->render();

/* SALVAR */
file_put_contents(BASE_PATH."/public/".$caminho,$dompdf->output());

$this->salvarDocumento(
$paciente_id,
$usuario_id,
"consentimento",
$nomeArquivo,
$caminho,
$descricao
);

/* EXIBIR */
$dompdf->stream($nomeArquivo,["Attachment"=>false]);

}

/* =============================
   SALVAR DOCUMENTO
============================= */

private function salvarDocumento($paciente_id,$usuario_id,$tipo,$nomeArquivo,$caminho,$descricao = null){

$db = new PDO("mysql:host=localhost;dbname=odonto","root","",[
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$sql = "INSERT INTO documentos_paciente
(paciente_id,usuario_id,nome_arquivo,arquivo,tipo,descricao)
VALUES
(:paciente,:usuario,:nome,:arquivo,:tipo,:descricao)";

$stmt = $db->prepare($sql);

$stmt->execute([
":paciente"=>$paciente_id,
":usuario"=>$usuario_id,
":nome"=>$nomeArquivo,
":arquivo"=>$caminho,
":tipo"=>$tipo,
":descricao"=>$descricao
]);

}

// ================CONTRATO===========
public function contrato_form($paciente_id){

    require_once BASE_PATH."/app/models/Paciente.php";

    $pacienteModel = new Paciente();
    $paciente = $pacienteModel->buscarPorId($paciente_id);

   $this->view("documentos/contrato_form", [
    "paciente" => $paciente
]);
}

// ==============GERAR CONTRATO =========

public function gerar_contrato(){

    require_once BASE_PATH."/app/models/Paciente.php";
    require_once BASE_PATH."/vendor/dompdf/autoload.inc.php";

    $paciente_id = $_POST['paciente_id'];
    $tratamento = $_POST['tratamento'];
    $valor = $_POST['valor'];

    $pacienteModel = new Paciente();
    $paciente = $pacienteModel->buscarPorId($paciente_id);

    // gera HTML
    ob_start();
    require BASE_PATH."/app/views/documentos/templates/contrato.php";
    $html = ob_get_clean();

    // PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();

    // nome arquivo
    $nomeArquivo = "contrato_".time().".pdf";

    // salvar
    file_put_contents(
        BASE_PATH."/public/uploads/".$nomeArquivo,
        $dompdf->output()
    );

    // 🔥 OPCIONAL (abrir direto)
    $dompdf->stream($nomeArquivo, ["Attachment" => false]);

    // ou redirecionar:
    // header("Location: ".BASE_URL."/prontuarios/index/".$paciente_id);
}

}