<?php

require_once BASE_PATH . "/app/models/Fornecedor.php";

class FornecedoresController extends Controller
{
    public function index()
    {
        $model = new Fornecedor();
        $fornecedores = $model->listar();

        $this->view("financeiro/fornecedores", [
            "fornecedores" => $fornecedores
        ]);
    }

    public function criar()
{
    require_once BASE_PATH . "/app/models/Fornecedor.php";

    $model = new Fornecedor();
    $fornecedores = $model->listar(); // 🔥 BUSCA REAL NO BANCO

    $this->view("financeiro/fornecedores_novo", [
        "fornecedores" => $fornecedores
    ]);
}

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = new Fornecedor();

            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'cnpj' => $_POST['cnpj'] ?? '',
                'telefone' => $_POST['telefone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'cep' => $_POST['cep'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'numero' => $_POST['numero'] ?? '',
                'bairro' => $_POST['bairro'] ?? '',
                'cidade' => $_POST['cidade'] ?? '',
                'estado' => $_POST['estado'] ?? ''
            ];

            $model->criar($dados);
        }

        header("Location: " . BASE_URL . "/fornecedores");
        exit;
    }

    public function excluir($id)
    {
        $model = new Fornecedor();
        $model->excluir($id);

        header("Location: " . BASE_URL . "/fornecedores");
        exit;
    }
}