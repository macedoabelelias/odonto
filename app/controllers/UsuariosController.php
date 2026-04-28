<?php

require_once BASE_PATH."/app/models/Usuario.php";
require_once BASE_PATH."/app/models/Nivel.php";
require_once BASE_PATH."/app/models/FormaPagamento.php";

class UsuariosController extends Controller{

/* ==========================
   VALIDAR CPF (CORRIGIDO)
========================== */
private function validarCPF($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11) return false;
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        for ($t = 9; $t < 11; $t++) {
            $soma = 0;

            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }

            $digito = ((10 * $soma) % 11) % 10;

            if ($cpf[$t] != $digito) return false;
        }

        return true;
    }

/* ==========================
   LISTAR
========================== */
public function index(){
    $model = new Usuario();
    $usuarios = $model->listar();

    $this->view("usuarios/index",[
        "usuarios"=>$usuarios
    ]);
}

/* ==========================
   NOVO
========================== */
public function criar()
{
    $this->view("usuarios/criar", [
        "niveis" => (new Nivel())->listar(),
        "formas" => (new FormaPagamento())->listar()
    ]);
}

/* ==========================
   SALVAR (CORRIGIDO)
========================== */
public function salvar(){

    require BASE_PATH . "/config/conexao.php";

    $model = new Usuario();

    $cpf = preg_replace('/\D/', '', $_POST['cpf_cnpj'] ?? '');
    $email = $_POST['email'] ?? '';

    // 🔥 CPF obrigatório
    if(empty($cpf)){
        $_SESSION['erro'] = "CPF é obrigatório.";
        header("Location: ".BASE_URL."/usuarios/criar");
        exit;
    }

    // 🔥 CPF inválido
    if(!$this->validarCPF($cpf)){
        $_SESSION['erro'] = "CPF inválido.";
        header("Location: ".BASE_URL."/usuarios/criar");
        exit;
    }

    // 🔥 CPF duplicado
    if($model->existeCPF($cpf)){
        $_SESSION['erro'] = "CPF já cadastrado.";
        header("Location: ".BASE_URL."/usuarios/criar");
        exit;
    }

    // 🔥 EMAIL duplicado
    if($model->existeEmail($email)){
        $_SESSION['erro'] = "Email já cadastrado.";
        header("Location: ".BASE_URL."/usuarios/criar");
        exit;
    }

     // 🔥 Nível 
    if(empty($_POST['nivel_id'])){
    $_SESSION['erro'] = "Selecione um nível.";
    header("Location: " . BASE_URL . "/usuarios/criar");
    exit;
}

    // 🔥 SENHA
    if(empty($_POST['senha'])){
        $_SESSION['erro'] = "Senha obrigatória.";
        header("Location: ".BASE_URL."/usuarios/criar");
        exit;
    }

    // FOTO
    $foto = null;
    if(!empty($_FILES['foto']['name'])){
        $nomeFoto = time() . "_" . $_FILES['foto']['name'];

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            BASE_PATH . "/public/assets/img/usuarios/" . $nomeFoto
        );

        $foto = $nomeFoto;
    }

    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = $pdo->prepare("
        INSERT INTO usuarios (
            nome, email, senha, nivel_id,
            cpf_cnpj, data_nascimento, telefone,
            cep, endereco, numero, bairro, cidade, estado,
            especialidade, registro_conselho,
            cargo, forma_recebimento, forma_pagamento_id, chave_pix, foto
        ) VALUES (
            :nome, :email, :senha, :nivel_id,
            :cpf_cnpj, :data_nascimento, :telefone,
            :cep, :endereco, :numero, :bairro, :cidade, :estado,
            :especialidade, :registro_conselho,
            :cargo, :forma_pagamento_id, :chave_pix, :foto
        )
    ");

    $sql->execute([
        ':nome' => $_POST['nome'],
        ':email' => $email,
        ':senha' => $senha,
        ':nivel_id' => $_POST['nivel_id'],
        ':cpf_cnpj' => $cpf,
        ':data_nascimento' => $_POST['data_nascimento'] ?: null,
        ':telefone' => $_POST['telefone'] ?? null,
        ':cep' => $_POST['cep'] ?? null,
        ':endereco' => $_POST['endereco'] ?? null,
        ':numero' => $_POST['numero'] ?? null,
        ':bairro' => $_POST['bairro'] ?? null,
        ':cidade' => $_POST['cidade'] ?? null,
        ':estado' => $_POST['estado'] ?? null,
        ':especialidade' => $_POST['especialidade'] ?? null,
        ':registro_conselho' => $_POST['registro_conselho'] ?? null,
        ':cargo' => $_POST['cargo'] ?? null,
        ':forma_recebimento' => $_POST['forma_recebimento'] ?? null,
        ':forma_pagamento_id' => $_POST['forma_pagamento_id'] ?? null,
        ':chave_pix' => $_POST['chave_pix'] ?? null,
        ':foto' => $foto
    ]);

    header("Location: " . BASE_URL . "/usuarios");
    exit;
}


/* ==========================
   EDITAR
========================== */
public function editar($id)
{
    $this->view("usuarios/editar", [
        "usuario" => (new Usuario())->buscarPorId($id),
        "niveis" => (new Nivel())->listar(),
        "formas" => (new FormaPagamento())->listar()
    ]);
}

public function atualizar($id)
{
    require BASE_PATH . "/config/conexao.php";

    $model = new Usuario();

    // 🔥 DADOS DO FORMULÁRIO
    $dados = [
        'id' => $id,
        'nome' => $_POST['nome'] ?? null,
        'email' => $_POST['email'] ?? null,
        'nivel_id' => $_POST['nivel_id'] ?? null,
        'cpf_cnpj' => preg_replace('/\D/', '', $_POST['cpf_cnpj'] ?? ''),
        'data_nascimento' => $_POST['data_nascimento'] ?? null,
        'telefone' => $_POST['telefone'] ?? null,
        'cep' => $_POST['cep'] ?? null,
        'endereco' => $_POST['endereco'] ?? null,
        'numero' => $_POST['numero'] ?? null,
        'bairro' => $_POST['bairro'] ?? null,
        'cidade' => $_POST['cidade'] ?? null,
        'estado' => $_POST['estado'] ?? null,
        'especialidade' => $_POST['especialidade'] ?? null,
        'registro_conselho' => $_POST['registro_conselho'] ?? null,
        'cargo' => $_POST['cargo'] ?? null,
        'forma_recebimento' => $_POST['forma_recebimento'] ?? null, // 🔥 AQUI
        'forma_pagamento_id' => $_POST['forma_pagamento_id'] ?? null,
        'chave_pix' => $_POST['chave_pix'] ?? null
    ];

    // 🔥 ATUALIZA NO BANCO
    $model->atualizar($dados);

    header("Location: " . BASE_URL . "/usuarios");
    exit;
}

/* ==========================
   EXCLUIR
========================== */
public function excluir($id){
    (new Usuario())->excluir($id);
    header("Location: ".BASE_URL."/usuarios");
}
}