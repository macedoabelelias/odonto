<?php

require_once BASE_PATH."/app/models/Usuario.php";

class UsuariosController extends Controller{

/* LISTAR */

public function index(){

$model = new Usuario();

$usuarios = $model->listar();

$this->view("usuarios/index",[
"usuarios"=>$usuarios
]);

}

/* NOVO USUARIO */

public function criar(){

$this->view("usuarios/criar");

}

/* SALVAR */

public function salvar(){

    require BASE_PATH . "/config/conexao.php";

    // upload da foto
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

            nome,
            email,
            senha,
            nivel,
            cpf_cnpj,
            data_nascimento,
            telefone,
            cep,
            endereco,
            numero,
            bairro,
            cidade,
            estado,
            especialidade,
            registro_conselho,
            cargo,
            forma_recebimento,
            chave_pix,
            foto

        ) VALUES (

            :nome,
            :email,
            :senha,
            :nivel,
            :cpf_cnpj,
            :data_nascimento,
            :telefone,
            :cep,
            :endereco,
            :numero,
            :bairro,
            :cidade,
            :estado,
            :especialidade,
            :registro_conselho,
            :cargo,
            :forma_recebimento,
            :chave_pix,
            :foto

        )

    ");

    $sql->bindValue(":nome", $_POST['nome']);
    $sql->bindValue(":email", $_POST['email']);
    $sql->bindValue(":senha", $senha);
    $sql->bindValue(":nivel", $_POST['nivel']);
    $sql->bindValue(":cpf_cnpj", $_POST['cpf_cnpj']);
    $sql->bindValue(":data_nascimento", $_POST['data_nascimento']);
    $sql->bindValue(":telefone", $_POST['telefone']);
    $sql->bindValue(":cep", $_POST['cep']);
    $sql->bindValue(":endereco", $_POST['endereco']);
    $sql->bindValue(":numero", $_POST['numero']);
    $sql->bindValue(":bairro", $_POST['bairro']);
    $sql->bindValue(":cidade", $_POST['cidade']);
    $sql->bindValue(":estado", $_POST['estado']);
    $sql->bindValue(":especialidade", $_POST['especialidade']);
    $sql->bindValue(":registro_conselho", $_POST['registro_conselho']);
    $sql->bindValue(":cargo", $_POST['cargo']);
    $sql->bindValue(":forma_recebimento", $_POST['forma_recebimento']);
    $sql->bindValue(":chave_pix", $_POST['chave_pix']);
    $sql->bindValue(":foto", $foto);

    $sql->execute();

    header("Location: " . BASE_URL . "/usuarios");
    exit;

}

/* EDITAR */

public function editar($id){

$model = new Usuario();

$usuario = $model->buscar($id);

$this->view("usuarios/editar",[
"usuario"=>$usuario
]);

}

/* ATUALIZAR */

public function atualizar(){

require BASE_PATH . "/config/conexao.php";

$id = $_POST["id"];

$senhaSQL = "";
$paramsSenha = [];

if(!empty($_POST["nova_senha"])){

if($_POST["nova_senha"] != $_POST["confirmar_senha"]){

die("As senhas não conferem.");

}

$senhaHash = password_hash($_POST["nova_senha"], PASSWORD_DEFAULT);

$senhaSQL = ", senha = :senha";
$paramsSenha["senha"] = $senhaHash;

}

$sql = $pdo->prepare("

UPDATE usuarios SET

nome = :nome,
email = :email,
cpf_cnpj = :cpf_cnpj,
data_nascimento = :data_nascimento,
telefone = :telefone,
cep = :cep,
endereco = :endereco,
numero = :numero,
bairro = :bairro,
cidade = :cidade,
estado = :estado,
especialidade = :especialidade,
registro_conselho = :registro_conselho,
cargo = :cargo,
forma_recebimento = :forma_recebimento,
chave_pix = :chave_pix,
nivel = :nivel

$senhaSQL

WHERE id = :id

");

$sql->bindValue(":nome", $_POST["nome"]);
$sql->bindValue(":email", $_POST["email"]);
$sql->bindValue(":cpf_cnpj", $_POST["cpf"]);
$sql->bindValue(":data_nascimento", $_POST["data_nascimento"]);
$sql->bindValue(":telefone", $_POST["telefone"]);
$sql->bindValue(":cep", $_POST["cep"]);
$sql->bindValue(":endereco", $_POST["endereco"]);
$sql->bindValue(":numero", $_POST["numero"]);
$sql->bindValue(":bairro", $_POST["bairro"]);
$sql->bindValue(":cidade", $_POST["cidade"]);
$sql->bindValue(":estado", $_POST["estado"]);
$sql->bindValue(":especialidade", $_POST["especialidade"]);
$sql->bindValue(":registro_conselho", $_POST["registro_conselho"]);
$sql->bindValue(":cargo", $_POST["cargo"]);
$sql->bindValue(":forma_recebimento", $_POST["forma_recebimento"]);
$sql->bindValue(":chave_pix", $_POST["chave_pix"]);
$sql->bindValue(":nivel", $_POST["nivel"]);
$sql->bindValue(":id", $id);

if(!empty($senhaSQL)){
$sql->bindValue(":senha", $senhaHash);
}

$sql->execute();

header("Location: ".BASE_URL."/usuarios");

exit;

}

/* EXCLUIR */

public function excluir($id){

$model = new Usuario();

$model->excluir($id);

header("Location: ".BASE_URL."/usuarios");

}

public function perfil(){

require BASE_PATH . "/config/conexao.php";

$id = $_SESSION['usuario_id'];

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$sql->execute([$id]);

$usuario = $sql->fetch(PDO::FETCH_ASSOC);

$this->view("usuarios/perfil",[
"usuario"=>$usuario
]);

}

public function atualizarPerfil(){

require BASE_PATH . "/config/conexao.php";

$id = $_POST["id"];

$foto = null;

if(!empty($_FILES['foto']['name'])){

$nomeFoto = time()."_".$_FILES['foto']['name'];

move_uploaded_file(
$_FILES['foto']['tmp_name'],
BASE_PATH."/public/assets/img/usuarios/".$nomeFoto
);

$foto = $nomeFoto;

}

$senhaSQL = "";
$senhaHash = null;

if(!empty($_POST["nova_senha"])){

if($_POST["nova_senha"] != $_POST["confirmar_senha"]){
die("As senhas não conferem.");
}

$senhaHash = password_hash($_POST["nova_senha"], PASSWORD_DEFAULT);

$senhaSQL = ", senha = :senha";

}

$sql = $pdo->prepare("

UPDATE usuarios SET

nome = :nome,
email = :email,
cpf_cnpj = :cpf_cnpj,
telefone = :telefone,
especialidade = :especialidade,
registro_conselho = :registro_conselho

".($foto ? ", foto = :foto" : "")."

$senhaSQL

WHERE id = :id

");

$sql->bindValue(":nome", $_POST["nome"]);
$sql->bindValue(":email", $_POST["email"]);
$sql->bindValue(":telefone", $_POST["telefone"]);
$sql->bindValue(":cpf_cnpj", $_POST["cpf_cnpj"]);
$sql->bindValue(":especialidade", $_POST["especialidade"]);
$sql->bindValue(":registro_conselho", $_POST["registro_conselho"]);
$sql->bindValue(":id", $id);

if($foto){
$sql->bindValue(":foto", $foto);
}

if($senhaSQL){
$sql->bindValue(":senha", $senhaHash);
}

$sql->execute();

header("Location: ".BASE_URL."/usuarios/perfil");
exit;

}

}