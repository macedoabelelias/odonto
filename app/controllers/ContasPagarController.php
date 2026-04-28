<?php

require_once BASE_PATH . "/app/models/ContaPagar.php";

class ContasPagarController extends Controller
{

public function index($filtro = null)
{
    $model = new ContaPagar();

    $contas = $model->listar($filtro);
    $resumo = $model->resumoFinanceiro();

    require BASE_PATH . "/app/views/layout/header.php";
    require BASE_PATH . "/app/views/financeiro/contas_pagar.php";
    require BASE_PATH . "/app/views/layout/footer.php";
}


    public function criar()
{
    require BASE_PATH . "/app/views/layout/header.php";

    require BASE_PATH . "/app/views/financeiro/contas_pagar_nova.php";

    require BASE_PATH . "/app/views/layout/footer.php";
}

    public function salvar()
    {
        $dados = [
            'descricao' => $_POST['descricao'] ?? '',
            'valor' => $_POST['valor'] ?? 0,
            'data_vencimento' => $_POST['data_vencimento'] ?? ''
        ];

        $model = new ContaPagar();
        $model->criar($dados);

        header("Location: " . BASE_URL . "/contasPagar");
        exit;
    }


    public function pagar($id)
    {
        $forma = $_POST['forma_pagamento'] ?? 'dinheiro';

        $model = new ContaPagar();
        $model->pagar($id, $forma);

        header("Location: " . BASE_URL . "/contasPagar");
        exit;
    }

    public function excluir($id)
{
    $model = new ContaPagar();
    $model->excluir($id);

    header("Location: " . BASE_URL . "/contasPagar");
    exit;
}
}