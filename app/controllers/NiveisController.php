<?php

require_once BASE_PATH."/app/models/Nivel.php";

class NiveisController extends Controller
{

    public function index()
    {
        $model = new Nivel();
        $dados['niveis'] = $model->getAll();

        $this->view('niveis/index', $dados, 'layout');
    }

    // ✅ CRIAR (SEM DADOS)
   public function criar()
{
    $dados = []; // 🔥 importante

    $this->view('niveis/form', $dados, 'layout');
}


    public function salvar()
    {
        $model = new Nivel();

        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';

        if($nome){
            $model->create($nome, $descricao);
        }

        header("Location: ".BASE_URL."/niveis");
        exit;
    }

    // ✅ EDITAR (COM DADOS)
    public function editar($id)
    {
        $model = new Nivel();

        $dados = [];
        $dados['nivelEdit'] = $model->getById($id);

        $this->view('niveis/form', $dados, 'layout');
    }

    public function atualizar($id)
    {
        $model = new Nivel();

        $model->update(
            $id,
            $_POST['nome'],
            $_POST['descricao']
        );

        header("Location: ".BASE_URL."/niveis");
        exit;
    }

    public function excluir($id)
    {
        $model = new Nivel();

        if(!$model->delete($id)){
            die("Não é possível excluir: existem usuários com esse nível.");
        }

        header("Location: ".BASE_URL."/niveis");
        exit;
    }
}