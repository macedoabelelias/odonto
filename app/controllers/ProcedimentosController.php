<?php

require_once BASE_PATH . "/app/models/Procedimento.php";
require_once BASE_PATH . "/app/models/Convenio.php";

class ProcedimentosController extends Controller
{
    public function index()
    {
        $procedimentos = (new Procedimento())->listar();

        $this->view("cadastros/procedimentos", [
            "procedimentos" => $procedimentos
        ]);
    }

    public function criar()
    {
        $this->view("cadastros/procedimentos_novo");
    }

    public function editar($id)
    {
        $procedimento = (new Procedimento())->buscar($id);

        $this->view("cadastros/procedimentos_novo", [
            "procedimento" => $procedimento
        ]);
    }

public function salvar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nomeIcone = null;

        // 🔥 UPLOAD DO ÍCONE
        if (!empty($_FILES['icone_upload']['name'])) {

            $arquivo = $_FILES['icone_upload'];

            $nomeOriginal = basename($arquivo['name']);
            $nomeOriginal = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nomeOriginal);
            $nomeOriginal = strtolower($nomeOriginal);

            $pasta = BASE_PATH . "/public/assets/img/procedimentos/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            $nomeIcone = $nomeOriginal;

            move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeIcone);
        }

        $dados = [
            'nome' => $_POST['nome'],
            'tipo' => $_POST['tipo'],
            'local' => $_POST['local'],
            'abrangencia' => $_POST['abrangencia'],
            'codigo_tuss' => $_POST['codigo_tuss'],
            'valor_particular' => str_replace(',', '.', $_POST['valor_particular']),
            'quantidade_us' => str_replace(',', '.', $_POST['quantidade_us']),
            'icone' => $nomeIcone
        ];

        (new Procedimento())->criar($dados);
    }

    header("Location: " . BASE_URL . "/procedimentos");
    exit;
}



public function atualizar($id)
{
    $model = new Procedimento();

    $procedimentoAtual = $model->buscar($id);

    $nomeIcone = $procedimentoAtual['icone'];

    // 🔥 SE ENVIAR NOVO ÍCONE
    if (!empty($_FILES['icone_upload']['name'])) {

        $arquivo = $_FILES['icone_upload'];

        $nomeOriginal = basename($arquivo['name']);
        $nomeOriginal = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nomeOriginal);
        $nomeOriginal = strtolower($nomeOriginal);

        $pasta = BASE_PATH . "/public/assets/img/procedimentos/";

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeIcone = $nomeOriginal;

        move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeIcone);
    }

    $dados = [
        'nome' => $_POST['nome'],
        'tipo' => $_POST['tipo'],
        'local' => $_POST['local'],
        'abrangencia' => $_POST['abrangencia'],
        'codigo_tuss' => $_POST['codigo_tuss'],
        'valor_particular' => str_replace(',', '.', $_POST['valor_particular']),
        'quantidade_us' => str_replace(',', '.', $_POST['quantidade_us']),
        'icone' => $nomeIcone
    ];

    $model->atualizar($id, $dados);

    header("Location: " . BASE_URL . "/procedimentos");
    exit;
}

public function atualizarStatus(){

    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;

    if(!$id || !$status){
        echo json_encode(["erro" => "Dados inválidos"]);
        return;
    }

    $model = new Procedimento();

    $ok = $model->atualizarStatusPorId($id, $status);

    echo json_encode([
        "sucesso" => $ok
    ]);
}

public function excluir($id)
{
    $model = new Procedimento();

    $model->excluir($id);

    header("Location: " . BASE_URL . "/procedimentos");
    exit;
}
}