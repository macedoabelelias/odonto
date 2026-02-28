<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin();

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];

if($id){

    if(!empty($senha)){
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome=?, email=?, senha=?, nivel=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome,$email,$senhaHash,$nivel,$id]);
    } else {
        $sql = "UPDATE usuarios SET nome=?, email=?, nivel=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome,$email,$nivel,$id]);
    }

} else {

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome,email,senha,nivel) VALUES (?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome,$email,$senhaHash,$nivel]);
}

header("Location: usuarios.php");
exit;