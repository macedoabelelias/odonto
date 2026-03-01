<?php

class FornecedorController {

    private $fornecedor;

    public function __construct($pdo) {
        $this->fornecedor = new Fornecedor($pdo);
    }

    public function index() {
        $dados = $this->fornecedor->listar();
        require 'views/fornecedores/listar.php';
    }

    public function criar() {
        if($_POST){
            $this->fornecedor->cadastrar($_POST);
            header("Location: /fornecedores");
            exit;
        }

        require 'views/fornecedores/cadastrar.php';
    }

    public function editar($id) {

        if($_POST){
            $_POST['id'] = $id;
            $this->fornecedor->atualizar($_POST);
            header("Location: /fornecedores");
            exit;
        }

        $fornecedor = $this->fornecedor->buscarPorId($id);
        require 'views/fornecedores/editar.php';
    }

    public function deletar($id) {
        $this->fornecedor->excluir($id);
        header("Location: /fornecedores");
        exit;
    }
}