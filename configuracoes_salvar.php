<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin();

$nome = $_POST['nome_clinica'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];

$config = $pdo->query("SELECT * FROM configuracoes LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$logoAtual = $config['logo'];

if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0){

    $pasta = "uploads/";
    $nomeArquivo = uniqid() . "_" . $_FILES['logo']['name'];
    move_uploaded_file($_FILES['logo']['tmp_name'], $pasta.$nomeArquivo);

    $logoAtual = $nomeArquivo;
}

$stmt = $pdo->prepare("UPDATE configuracoes 
SET nome_clinica=?, email=?, telefone=?, logo=? 
WHERE id=1");

$stmt->execute([$nome,$email,$telefone,$logoAtual]);

header("Location: configuracoes.php");
exit;