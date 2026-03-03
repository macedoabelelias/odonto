<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin();

$nome = $_POST['nome_clinica'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];

$config = $pdo->query("SELECT * FROM configuracoes LIMIT 1")
              ->fetch(PDO::FETCH_ASSOC);

$logoNome = $config['logo'];

// UPLOAD LOGO
if(!empty($_FILES['logo']['name'])){

    $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $logoNome = uniqid().".".$ext;

    move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/".$logoNome);
}

$pdo->prepare("
    UPDATE configuracoes 
    SET nome_clinica=:nome,
        email=:email,
        telefone=:telefone,
        logo=:logo
    WHERE id=:id
")->execute([
    ':nome'=>$nome,
    ':email'=>$email,
    ':telefone'=>$telefone,
    ':logo'=>$logoNome,
    ':id'=>$config['id']
]);

header("Location: configuracoes.php");
exit;