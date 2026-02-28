<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? null;
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$cep = $_POST['cep'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$observacoes = $_POST['observacoes'] ?? '';

if($id){

    $sql = $pdo->prepare("
        UPDATE pacientes SET
        nome=?, cpf=?, data_nascimento=?, telefone=?, email=?,
        cep=?, endereco=?, bairro=?, cidade=?, estado=?, observacoes=?
        WHERE id=?
    ");

    $sql->execute([
        $nome, $cpf, $data_nascimento, $telefone, $email,
        $cep, $endereco, $bairro, $cidade, $estado, $observacoes,
        $id
    ]);

} else {

    $sql = $pdo->prepare("
        INSERT INTO pacientes
        (nome, cpf, data_nascimento, telefone, email, cep, endereco, bairro, cidade, estado, observacoes)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");

    $sql->execute([
        $nome, $cpf, $data_nascimento, $telefone, $email,
        $cep, $endereco, $bairro, $cidade, $estado, $observacoes
    ]);
}

header("Location: pacientes.php");
exit;