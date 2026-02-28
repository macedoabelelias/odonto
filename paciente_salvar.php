<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

$id = $_POST['id'] ?? null;

// ================= FOTO =================
$foto = null;

if(!empty($_FILES['foto']['name'])){

    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nomeFoto = uniqid().".".$extensao;

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        "uploads/".$nomeFoto
    );

    $foto = $nomeFoto;
}

// ================= DADOS =================

$nome = $_POST['nome'] ?? null;
$telefone = $_POST['telefone'] ?? null;
$email = $_POST['email'] ?? null;
$cpf = $_POST['cpf'] ?? null;
$data_nascimento = $_POST['data_nascimento'] ?? null;
$tipo_sanguineo = $_POST['tipo_sanguineo'] ?? null;
$estado_civil = $_POST['estado_civil'] ?? null;
$genero = $_POST['genero'] ?? null;
$profissao = $_POST['profissao'] ?? null;

$cep = $_POST['cep'] ?? null;
$endereco = $_POST['endereco'] ?? null;
$bairro = $_POST['bairro'] ?? null;
$cidade = $_POST['cidade'] ?? null;
$estado = $_POST['estado'] ?? null;

$convenio = $_POST['convenio'] ?? null;
$instagram = $_POST['instagram'] ?? null;
$whatsapp = $_POST['whatsapp'] ?? null;

$responsavel_nome = $_POST['responsavel_nome'] ?? null;
$responsavel_telefone = $_POST['responsavel_telefone'] ?? null;
$responsavel_email = $_POST['responsavel_email'] ?? null;
$responsavel_cpf = $_POST['responsavel_cpf'] ?? null;

$observacoes = $_POST['observacoes'] ?? null;

// ================= INSERT =================

$sql = $pdo->prepare("
INSERT INTO pacientes (
foto, nome, telefone, email, cpf, data_nascimento,
tipo_sanguineo, estado_civil, genero, profissao,
cep, endereco, bairro, cidade, estado,
convenio, instagram, whatsapp,
responsavel_nome, responsavel_telefone, responsavel_email, responsavel_cpf,
observacoes
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$sql->execute([
$foto,
$nome,
$telefone,
$email,
$cpf,
$data_nascimento,
$tipo_sanguineo,
$estado_civil,
$genero,
$profissao,
$cep,
$endereco,
$bairro,
$cidade,
$estado,
$convenio,
$instagram,
$whatsapp,
$responsavel_nome,
$responsavel_telefone,
$responsavel_email,
$responsavel_cpf,
$observacoes
]);

header("Location: pacientes.php");
exit;