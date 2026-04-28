<?php

require_once BASE_PATH . "/app/models/Convenio.php";

class ConveniosController extends Controller
{
    // 🔒 FUNÇÃO DE SEGURANÇA
    private function checkAcesso()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $nivel = strtolower($_SESSION['usuario_nivel'] ?? '');

        // ✅ só admin e financeiro podem acessar
        if (!in_array($nivel, ['administrador', 'financeiro'])) {
            die("Acesso negado");
        }
    }

    public function index()
    {
        $this->checkAcesso(); // 🔥 AQUI

        $convenios = (new Convenio())->listar();

        $this->view("convenios/index", [
            "convenios" => $convenios
        ]);
    }

    public function novo()
    {
        $this->checkAcesso(); // 🔥 AQUI

        $this->view("convenios/form");
    }

    public function salvar()
    {
        $this->checkAcesso(); // 🔥 AQUI

        $dados = [
            'nome' => $_POST['nome'],
            'percentual' => $_POST['percentual'],
            'valor_us' => str_replace(',', '.', $_POST['valor_us'])
        ];

        (new Convenio())->criar($dados);

        header("Location: " . BASE_URL . "/convenios");
    }

    public function editar($id)
    {
        $this->checkAcesso(); // 🔥 AQUI

        $convenio = (new Convenio())->buscar($id);

        $this->view("convenios/form", [
            "convenio" => $convenio
        ]);
    }

    public function atualizar($id)
    {
        $this->checkAcesso(); // 🔥 AQUI

        $dados = [
            'nome' => $_POST['nome'],
            'percentual' => $_POST['percentual'],
            'valor_us' => str_replace(',', '.', $_POST['valor_us'])
        ];

        (new Convenio())->atualizar($id, $dados);

        header("Location: " . BASE_URL . "/convenios");
    }

    public function excluir($id)
    {
        $this->checkAcesso(); // 🔥 AQUI

        (new Convenio())->excluir($id);

        header("Location: " . BASE_URL . "/convenios");
    }
}