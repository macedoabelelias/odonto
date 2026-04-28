<?php

require_once BASE_PATH . "/app/models/Compra.php";
require_once BASE_PATH . "/app/models/Fornecedor.php";
require_once BASE_PATH . "/app/models/Produto.php";

class ComprasController extends Controller
{
    public function index()
    {
        $model = new Compra();
        $compras = $model->listar();

        $this->view("estoque/compras/index", [
            "compras" => $compras
        ]);
    }

    public function criar()
    {
        $fornecedores = (new Fornecedor())->listar();
        $produtos = (new Produto())->listar();

        // 🔥 CORRIGIDO (antes era compras_novo)
        $this->view("estoque/compras/form", [
            "fornecedores" => $fornecedores,
            "produtos" => $produtos
        ]);
    }

    public function salvar()
{
    try {

        // 🔥 validação básica
        if (empty($_POST['fornecedor_id'])) {
            throw new Exception("Fornecedor é obrigatório.");
        }

        if (empty($_POST['itens']) || !is_array($_POST['itens'])) {
            throw new Exception("Nenhum item informado.");
        }

        // 🔥 monta dados (não confiar no total do front)
        $dados = [
            'fornecedor_id' => (int) $_POST['fornecedor_id'],
            'data' => !empty($_POST['data']) ? $_POST['data'] : date('Y-m-d')
        ];

        // 🔥 sanitizar itens
        $itens = [];

        foreach ($_POST['itens'] as $item) {

            // ignora linhas vazias
            if (empty($item['produto_id']) || empty($item['quantidade'])) {
                continue;
            }

            $itens[] = [
                'produto_id' => (int) $item['produto_id'],
                'quantidade' => (int) $item['quantidade'],
                'custo' => $item['custo'] ?? '0'
            ];
        }

        if (empty($itens)) {
            throw new Exception("Adicione pelo menos um item válido.");
        }

        // 🔥 salvar
        $compra = new Compra();
        $compra->criar($dados, $itens);

        // 🔥 sucesso
        header("Location: " . BASE_URL . "/compras");
        exit;

    } catch (Exception $e) {

        // 🔥 erro controlado (melhor que die)
        echo "<script>alert('Erro: " . addslashes($e->getMessage()) . "'); history.back();</script>";
        exit;
    }
}

    public function ver($id)
    {
        $model = new Compra();
        $dados = $model->buscarPorId($id);

        if (!$dados['compra']) {
            die("Compra não encontrada");
        }

        // 🔥 CORRIGIDO (antes era compras_ver)
        $this->view("estoque/compras/show", $dados);
    }

    public function editar($id)
{
    $model = new Compra();

    $dados = $model->buscarPorId($id);

    $fornecedores = (new Fornecedor())->listar();
    $produtos = (new Produto())->listar();

    if (!$dados['compra']) {
        die("Compra não encontrada");
    }

    $this->view("estoque/compras/form", [
        "compra" => $dados['compra'],
        "itens" => $dados['itens'],
        "fornecedores" => $fornecedores,
        "produtos" => $produtos
    ]);
}

public function atualizar($id)
{
    $dados = [
        'fornecedor_id' => $_POST['fornecedor_id'],
        'data' => $_POST['data'],
        'valor_total' => $_POST['valor_total']
    ];

    $itens = $_POST['itens'];

    (new Compra())->atualizar($id, $dados, $itens);

    header("Location: " . BASE_URL . "/compras");
    exit;
}

public function excluir($id)
{
    (new Compra())->excluir($id);

    header("Location: " . BASE_URL . "/compras");
    exit;
}
}