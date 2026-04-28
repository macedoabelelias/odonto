<?php

require_once BASE_PATH . "/app/models/Prontuario.php";
require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Radiografia.php";
require_once BASE_PATH . "/app/models/Orcamento.php";

class ProntuariosController extends Controller
{
    private $pacienteModel;
    private $orcamentoModel;

    public function __construct()
    {
        $this->pacienteModel = new Paciente();
        $this->orcamentoModel = new Orcamento();
    }

/* ==========================
   ABRIR PRONTUÁRIO
========================== */

public function index($paciente_id = null)
{
    $nivel = $_SESSION['usuario_nivel'] ?? '';
    $usuario_id = $_SESSION['usuario_id'] ?? null;

    // 🔒 BLOQUEIO RECEPÇÃO
    if($nivel == 'recepcionista' || $nivel == 'recepcao'){
        header("Location: ".BASE_URL."/pacientes");
        exit;
    }

    // 🔒 VALIDA PACIENTE
    if(!$paciente_id){
        header("Location: ".BASE_URL."/pacientes");
        exit;
    }

    $pacienteModel = new Paciente();
    $prontuarioModel = new Prontuario();
    $radiografiaModel = new Radiografia();

    $paciente = $pacienteModel->buscarPorId($paciente_id);

    // 🔒 DENTISTA SÓ VÊ SEU PACIENTE
    if($nivel == 'dentista'){
        if($paciente['usuario_id'] != $usuario_id){
            header("Location: ".BASE_URL."/pacientes");
            exit;
        }
    }

    // 📋 DADOS EXISTENTES
    $registros = $prontuarioModel->buscarRegistrosPaciente($paciente_id);
    $radiografias = $radiografiaModel->listarPorPaciente($paciente_id);
    $dentesRX = $radiografiaModel->dentesComRadiografia($paciente_id);

    require_once BASE_PATH."/app/models/Documento.php";
    $documentoModel = new Documento();
    $historicoPDFs = $documentoModel->listarPorPaciente($paciente_id);

    // 🔥 PROCEDIMENTOS
    require_once BASE_PATH . "/app/models/Procedimento.php";
    $procedimentoModel = new Procedimento();
    $procedimentos = $procedimentoModel->listar();

    // 🔥 🔥 PLANO DE TRATAMENTO (IGUAL AO PDF)
    require_once BASE_PATH . "/app/models/Orcamento.php";

    $orcamentoModel = new Orcamento();
    $orcamento = $orcamentoModel->ultimo($paciente_id);

    $plano = $orcamento['itens'] ?? [];

    // 🔥 VIEW
    require_once BASE_PATH."/app/models/EvolucaoClinica.php";

    $evolucaoModel = new EvolucaoClinica();
    $evolucoes = $evolucaoModel->listarPorPaciente($paciente_id);

    $this->view("prontuarios/index", [
        "paciente" => $paciente,
        "registros" => $registros,
        "radiografias" => $radiografias,
        "dentesRX" => $dentesRX,
        "historicoPDFs" => $historicoPDFs,
        "procedimentos" => $procedimentos,
        "plano" => $plano,
        "evolucoes" => $evolucoes // 🔥 ESSA LINHA
    ]);
}

/* ==========================
   SALVAR PROCEDIMENTO
========================== */

public function salvarRegistro()
{

    header('Content-Type: application/json');

    $model = new Prontuario();

    $usuario = $_SESSION['usuario_id'] ?? null;

    // 🔥 MODEL PROCEDIMENTO
    require_once BASE_PATH . "/app/models/Procedimento.php";
    $procModel = new Procedimento();

    // 🔥 PEGA ID
    $procedimento_id = $_POST['procedimento'] ?? null;

    if(!$procedimento_id){
        echo json_encode(["status"=>"erro","msg"=>"Procedimento não enviado"]);
        exit;
    }

    // 🔥 CORREÇÃO PRINCIPAL AQUI
    $proc = $procModel->buscar($procedimento_id);

    if(!$proc){
        echo json_encode(["status"=>"erro","msg"=>"Procedimento não encontrado"]);
        exit;
    }

    $dados = [

        "paciente_id" => $_POST['paciente_id'] ?? null,
        "usuario_id" => $usuario,
        "dente" => $_POST['dente'] ?? null,
        "face" => $_POST['face'] ?? null,

        // 🔥 SALVA NOME (ESSENCIAL)
        "procedimento" => $proc['nome'],

        "status" => $_POST['status'] ?? 'planejado',
        "observacoes" => $_POST['observacoes'] ?? null,
        "tipo" => "odontograma"

    ];

    $ok = $model->salvarRegistro($dados);

    echo json_encode([
        "status" => $ok ? "ok" : "erro"
    ]);

    exit;

}


/* ==========================
   LISTAR REGISTROS
========================== */

public function registros($paciente_id)
{

header('Content-Type: application/json');

$model = new Prontuario();

$dados = $model->buscarRegistrosPaciente((int)$paciente_id);

echo json_encode($dados);

}


/* ==========================
   HISTÓRICO DO DENTE
========================== */

public function historicoDente()
{

$data = json_decode(file_get_contents("php://input"),true);

$paciente = $data['paciente'] ?? null;
$dente = $data['dente'] ?? null;

$model = new Prontuario();

$historico = $model->historicoDente($paciente,$dente);

echo json_encode($historico);
exit;

}


/* ==========================
   REMOVER PROCEDIMENTO
========================== */

public function removerRegistro()
{

header('Content-Type: application/json');

$model = new Prontuario();

$paciente = $_POST["paciente_id"] ?? null;
$dente = $_POST["dente"] ?? null;

$model->removerPorDente($paciente,$dente);

echo json_encode(["status"=>"ok"]);
exit;

}


/* ==========================
   PROCEDIMENTO GERAL
========================== */

public function salvarProcedimento()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once BASE_PATH . "/app/models/ProntuarioProcedimento.php";
        require_once BASE_PATH . "/app/models/Procedimento.php";
        require_once BASE_PATH . "/app/models/ContaReceber.php";

        // 🔹 Dados do formulário
        $paciente_id     = $_POST['paciente_id'] ?? null;
        $dente           = $_POST['dente'] ?? '';
        $procedimento_id = $_POST['procedimento_id'] ?? null;
        $observacao      = $_POST['observacao'] ?? '';
        $status          = $_POST['status'] ?? 'planejado';
        $convenio_id     = $_POST['convenio_id'] ?? null;

        // 🔹 1. Salvar no prontuário
        $prontuario = new ProntuarioProcedimento();

        $prontuario->salvar([
            'paciente_id'     => $paciente_id,
            'dente'           => $dente,
            'procedimento_id' => $procedimento_id,
            'observacao'      => $observacao,
            'status'          => $status
        ]);

        // 🔹 2. Buscar dados do procedimento
        $procedimentoModel = new Procedimento();
        $proc = $procedimentoModel->buscar($dados['procedimento_id']);

        if (!$procedimento) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // 🔹 3. Definir valor (particular ou convênio)
        $valor = $procedimento['valor_particular'];

        if (!empty($convenio_id)) {

            $valorConvenio = $procedimentoModel->buscarValorConvenio(
                $procedimento_id,
                $convenio_id
            );

            if ($valorConvenio !== null) {
                $valor = $valorConvenio;
            }
        }

        // 🔹 4. Gerar financeiro (somente se NÃO for planejado)
        if ($status !== 'planejado') {

            $financeiro = new ContaReceber();

            $financeiro->criar([
                'paciente_id'     => $paciente_id,
                'descricao'       => $procedimento['nome'] . ' (Dente ' . $dente . ')',
                'valor'           => $valor,
                'data_vencimento' => date('Y-m-d'),
                'status'          => 'pendente'
            ]);
        }
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

/* ==========================
   TIMELINE CLÍNICA
========================== */

public function historicoPaciente($paciente)
{

header('Content-Type: application/json');

$model = new Prontuario();

$dados = $model->timelinePaciente($paciente);

echo json_encode($dados);
exit;

}


/* ==========================
   SALVAR EVOLUÇÃO
========================== */

public function salvarEvolucao(){

header('Content-Type: application/json');

$paciente = $_POST['paciente_id'] ?? null;
$descricao = $_POST['descricao'] ?? null;
$usuario = $_SESSION['usuario_id'] ?? null;

$model = new Prontuario();

$model->salvarEvolucao($paciente,$usuario,$descricao);

echo json_encode(["status"=>"ok"]);
exit;

}


/* ==========================
   SALVAR PLANO
========================== */

public function salvarPlano(){

    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);

    $paciente = $data['paciente_id'] ?? null;
    $descricao = $data['descricao'] ?? null;
    $usuario = $_SESSION['usuario_id'] ?? null;

    if(!$paciente){
        echo json_encode(["status"=>"erro","msg"=>"Paciente não enviado"]);
        exit;
    }

    $model = new Prontuario();

    $model->salvarPlano($paciente,$usuario,$descricao);

    echo json_encode(["status"=>"ok"]);
    exit;
}

public function pdfPlano($id)
{
    $modelPaciente = new Paciente();
    $paciente = $modelPaciente->buscarPorId($id);

    $modelOrcamento = new Orcamento();
    $orcamento = $modelOrcamento->ultimo($id);

    require __DIR__ . '/../views/prontuarios/pdf_plano.php';
}

public function pdfProntuario($id)
{
    $pacienteModel = new Paciente();
    $orcamentoModel = new Orcamento();

    $paciente = $pacienteModel->buscarPorId($id);
    $orcamento = $orcamentoModel->ultimo($id);

    // 🔥 EVOLUÇÃO CLÍNICA (FALTAVA ISSO)
    require_once BASE_PATH . "/app/models/EvolucaoClinica.php";

    $evolucaoModel = new EvolucaoClinica();
    $evolucoes = $evolucaoModel->listarPorPaciente($id);

    // 🔥 PROFISSIONAL
    $profissional = [
        'nome' => '',
        'cro'  => ''
    ];

    // 🔥 PEGA USUÁRIO LOGADO
    if (isset($_SESSION['usuario_id'])) {

        require_once BASE_PATH . "/app/models/Usuario.php";

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarPorId($_SESSION['usuario_id']);

        if ($usuario) {
            $profissional['nome'] = $usuario['nome'] ?? '';
            $profissional['cro']  = $usuario['registro_conselho'] ?? '';
        }
    }

    // 🔥 FALLBACK (caso não tenha usuário)
    if (empty($profissional['nome'])) {
        $config = require __DIR__ . '/../config/config.php';

        $profissional['nome'] = $config['nome_profissional'] ?? '';
        $profissional['cro']  = $config['cro_profissional'] ?? '';
    }

    // 🔥 ENVIA PARA VIEW (IMPORTANTE)
    require __DIR__ . '/../views/prontuarios/pdf_prontuario.php';
}

}