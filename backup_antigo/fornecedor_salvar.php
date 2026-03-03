<?php
require_once("config/conexao.php");

$sql = $pdo->prepare("INSERT INTO fornecedores
    (nome, cnpj, telefone, email, endereco, cidade, estado, status)
    VALUES (:nome, :cnpj, :telefone, :email, :endereco, :cidade, :estado, :status)");

$sql->execute([
    ':nome' => $_POST['nome'],
    ':cnpj' => $_POST['cnpj'],
    ':telefone' => $_POST['telefone'],
    ':email' => $_POST['email'],
    ':endereco' => $_POST['endereco'],
    ':cidade' => $_POST['cidade'],
    ':estado' => $_POST['estado'],
    ':status' => $_POST['status']
]);

header("Location: fornecedores.php");
exit;