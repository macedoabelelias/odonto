<?php

require_once BASE_PATH . "/app/models/Paciente.php";

class PacientesController extends Controller
{
    private $pacienteModel;

    public function __construct()
    {
        $this->pacienteModel = new Paciente();
    }

    /* ==========================
       LISTAR + BUSCA
    ========================== */
public function index()
{

$usuario_id = $_SESSION['usuario_id'] ?? null;
$nivel = $_SESSION['usuario_nivel'] ?? '';

$pacientes = [];

/* ADMIN OU RECEPÇÃO */

if($nivel == 'administrador' || $nivel == 'admin' || $nivel == 'recepcionista' || $nivel == 'recepcao'){

    if(!empty($_GET['busca'])){

        $pacientes = $this->pacienteModel->buscar($_GET['busca']);

    }else{

        $pacientes = $this->pacienteModel->listarTodos();

    }

}

/* DENTISTA */

elseif($nivel == 'dentista'){

    if(!empty($_GET['busca'])){

        $pacientes = $this->pacienteModel->buscarPorUsuario($_GET['busca'],$usuario_id);

    }else{

        $pacientes = $this->pacienteModel->listar($usuario_id);

    }

}

$this->view("pacientes/index",[
    "pacientes"=>$pacientes
]);

}


    /* ==========================
       CRIAR
    ========================== */
    public function criar()
    {
        $this->view("pacientes/criar");
    }

    /* ==========================
       SALVAR
    ========================== */
    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/pacientes");
            exit;
        }

        $cpf = $_POST["cpf"] ?? null;

        if (!empty($cpf) && $this->pacienteModel->cpfExiste($cpf)) {
            $_SESSION['erro'] = "Já existe um paciente com este CPF.";
            header("Location: " . BASE_URL . "/pacientes/criar");
            exit;
        }

        /* ========= UPLOAD FOTO ========= */
        $fotoNome = null;

        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {

            $pasta = BASE_PATH . "/public/uploads/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true);
            }

            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $fotoNome = uniqid() . "_paciente." . $ext;

            move_uploaded_file($_FILES['foto']['tmp_name'], $pasta . $fotoNome);
        }

        /* ========= DADOS ========= */
        $dados = [
            "usuario_id" => $_SESSION['usuario_id'],
            "foto" => $fotoNome,
            "nome" => $_POST["nome"] ?? null,
            "telefone" => $_POST["telefone"] ?? null,
            "email" => $_POST["email"] ?? null,
            "cpf" => $cpf,
            "data_nascimento" => $_POST["data_nascimento"] ?? null,
            "tipo_sanguineo" => $_POST["tipo_sanguineo"] ?? null,
            "estado_civil" => $_POST["estado_civil"] ?? null,
            "genero" => $_POST["genero"] ?? null,
            "profissao" => $_POST["profissao"] ?? null,
            "cep" => $_POST["cep"] ?? null,
            "endereco" => $_POST["endereco"] ?? null,
            "bairro" => $_POST["bairro"] ?? null,
            "cidade" => $_POST["cidade"] ?? null,
            "estado" => $_POST["estado"] ?? null,
            "convenio" => $_POST["convenio"] ?? null,
            "instagram" => $_POST["instagram"] ?? null,
            "whatsapp" => $_POST["whatsapp"] ?? null,
            "responsavel_nome" => $_POST["responsavel_nome"] ?? null,
            "responsavel_telefone" => $_POST["responsavel_telefone"] ?? null,
            "responsavel_email" => $_POST["responsavel_email"] ?? null,
            "responsavel_cpf" => $_POST["responsavel_cpf"] ?? null,
            "observacoes" => $_POST["observacoes"] ?? null
        ];

        $this->pacienteModel->salvar($dados);

        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }

    /* ==========================
       EDITAR
    ========================== */
    public function editar($id)
    {
        $paciente = $this->pacienteModel->buscarPorId($id);

        $this->view("pacientes/editar", [
            "paciente" => $paciente
        ]);
    }

    /* ==========================
       ATUALIZAR
    ========================== */
    public function atualizar($id)
    {
        $cpf = $_POST["cpf"] ?? null;

        if (!empty($cpf) && $this->pacienteModel->cpfExiste($cpf, $id)) {
            $_SESSION['erro'] = "Já existe outro paciente com este CPF.";
            header("Location: " . BASE_URL . "/pacientes/editar/" . $id);
            exit;
        }

        $pacienteAtual = $this->pacienteModel->buscarPorId($id);
        $fotoNome = $pacienteAtual['foto'] ?? null;

        /* ========= NOVA FOTO ========= */
        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {

            $pasta = BASE_PATH . "/public/uploads/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true);
            }

            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $fotoNome = uniqid() . "_paciente." . $ext;

            move_uploaded_file($_FILES['foto']['tmp_name'], $pasta . $fotoNome);
        }

        $dados = [
            "foto" => $fotoNome,
            "nome" => $_POST["nome"] ?? null,
            "telefone" => $_POST["telefone"] ?? null,
            "email" => $_POST["email"] ?? null,
            "cpf" => $cpf,
            "data_nascimento" => $_POST["data_nascimento"] ?? null,
            "tipo_sanguineo" => $_POST["tipo_sanguineo"] ?? null,
            "estado_civil" => $_POST["estado_civil"] ?? null,
            "genero" => $_POST["genero"] ?? null,
            "profissao" => $_POST["profissao"] ?? null,
            "cep" => $_POST["cep"] ?? null,
            "endereco" => $_POST["endereco"] ?? null,
            "bairro" => $_POST["bairro"] ?? null,
            "cidade" => $_POST["cidade"] ?? null,
            "estado" => $_POST["estado"] ?? null,
            "convenio" => $_POST["convenio"] ?? null,
            "instagram" => $_POST["instagram"] ?? null,
            "whatsapp" => $_POST["whatsapp"] ?? null,
            "responsavel_nome" => $_POST["responsavel_nome"] ?? null,
            "responsavel_telefone" => $_POST["responsavel_telefone"] ?? null,
            "responsavel_email" => $_POST["responsavel_email"] ?? null,
            "responsavel_cpf" => $_POST["responsavel_cpf"] ?? null,
            "observacoes" => $_POST["observacoes"] ?? null
        ];

        $this->pacienteModel->atualizar($id, $dados);

        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }

    /* ==========================
       EXCLUIR
    ========================== */
    public function excluir($id)
    {
        $this->pacienteModel->excluir($id);

        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }

    /* ==========================
       HISTÓRICO DO DENTE
    ========================== */
    public function historico($paciente_id, $dente = null)
    {
        $model = new Prontuario();

        if ($dente === null) {
            $url = $_GET['url'] ?? '';
            $partes = explode("/", $url);
            $dente = $partes[3] ?? null;
        }

        if (!$dente) {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }

        $dados = $model->getHistoricoDente($paciente_id, $dente);

        header('Content-Type: application/json');
        echo json_encode($dados);
        exit;
    }
}