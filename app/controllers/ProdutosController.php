<?php

require_once BASE_PATH . "/app/models/Produto.php";
require_once BASE_PATH . "/app/models/Fornecedor.php";

class ProdutosController extends Controller {

    public function index(){

        $model = new Produto();
        $produtos = $model->listar();

        $this->view("estoque/produtos/index", [
            "produtos" => $produtos
        ]);
    }

    public function criar(){

        $fornecedorModel = new Fornecedor();
        $fornecedores = $fornecedorModel->listar();

        $this->view("estoque/produtos/form", [
            "fornecedores" => $fornecedores
        ]);
    }

    public function salvar(){

        $model = new Produto();
        $model->salvar($_POST);

        header("Location: /odonto/public/produtos");
        exit;
    }

    public function editar($id){

    $model = new Produto();
    $produto = $model->buscar($id);

    $fornecedorModel = new Fornecedor();
    $fornecedores = $fornecedorModel->listar();

    $this->view("estoque/produtos/form", [
        "produto" => $produto,
        "fornecedores" => $fornecedores
    ]);
}

public function atualizar(){

    $model = new Produto();
    $model->atualizar($_POST);

    header("Location: /odonto/public/produtos");
    exit;
}

public function excluir($id){

    $model = new Produto();
    $model->excluir($id);

    header("Location: /odonto/public/produtos");
    exit;
}
}