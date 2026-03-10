<?php

class ConfiguracoesController extends Controller{

/* ==============================
   ABRIR CONFIGURAÇÕES
============================== */

public function index(){

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* SEGURANÇA - SOMENTE ADMIN */

if($_SESSION['usuario_nivel'] != 'admin'){
    die("Acesso negado");
}

require BASE_PATH . "/config/conexao.php";

/* BUSCAR CONFIGURAÇÕES */

$sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
$config = $sql->fetch(PDO::FETCH_ASSOC);

/* SE TABELA ESTIVER VAZIA */

if(!$config){

$pdo->query("
INSERT INTO configuracoes (nome_clinica,logo)
VALUES ('Minha Clínica','')
");

$sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
$config = $sql->fetch(PDO::FETCH_ASSOC);

}

$this->view("configuracoes/index",[
"config"=>$config
]);

}


/* ==============================
   SALVAR CONFIGURAÇÕES
============================== */

public function salvar(){

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* SEGURANÇA */

if($_SESSION['usuario_nivel'] != 'admin'){
    die("Acesso negado");
}

require BASE_PATH . "/config/conexao.php";

/* BUSCAR CONFIG */

$sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
$config = $sql->fetch(PDO::FETCH_ASSOC);

$id = $config['id'] ?? 1;


/* LOGO */

$logo = $config['logo'] ?? '';

if(!empty($_FILES['logo']['name'])){

$nomeLogo = time()."_".$_FILES['logo']['name'];

move_uploaded_file(
$_FILES['logo']['tmp_name'],
BASE_PATH."/public/assets/img/".$nomeLogo
);

$logo = $nomeLogo;

}


/* UPDATE */

$sql = $pdo->prepare("
UPDATE configuracoes SET

nome_clinica = :nome,
cnpj = :cnpj,
telefone = :telefone,
cep = :cep,
endereco = :endereco,
numero = :numero,
bairro = :bairro,
cidade = :cidade,
estado = :estado,
cor_sistema = :cor,
logo = :logo

WHERE id = :id
");

$sql->bindValue(":nome", $_POST['nome_clinica']);
$sql->bindValue(":cnpj", $_POST['cnpj']);
$sql->bindValue(":telefone", $_POST['telefone']);
$sql->bindValue(":cep", $_POST['cep']);
$sql->bindValue(":endereco", $_POST['endereco']);
$sql->bindValue(":numero", $_POST['numero']);
$sql->bindValue(":bairro", $_POST['bairro']);
$sql->bindValue(":cidade", $_POST['cidade']);
$sql->bindValue(":estado", $_POST['estado']);
$sql->bindValue(":cor", $_POST['cor_sistema']);
$sql->bindValue(":logo", $logo);
$sql->bindValue(":id", $id);

$sql->execute();

/* REDIRECIONAR */

header("Location: ".BASE_URL."/configuracoes");
exit;

}

}