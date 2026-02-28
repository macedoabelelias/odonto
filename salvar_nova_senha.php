<?php
require 'config/conexao.php';

$token = $_POST['token'] ?? '';
$senha = $_POST['senha'] ?? '';

if(!$token || !$senha){
    die("Dados inválidos");
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = $pdo->prepare("UPDATE usuarios 
SET senha=?, token_recuperacao=NULL, token_expira=NULL 
WHERE token_recuperacao=?");

$sql->execute([$hash,$token]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Senha alterada</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    height:100vh;
    background: linear-gradient(135deg,#eef2ff,#dbeafe,#e9d5ff);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: 'Segoe UI', sans-serif;
}

.card-success{
    background:#fff;
    border-radius:20px;
    padding:40px;
    width:400px;
    box-shadow:0 20px 40px rgba(0,0,0,.15);
    text-align:center;
}
</style>
</head>

<body>

<div class="card-success">
    <h4 class="text-success mb-3">Senha alterada com sucesso! ✅</h4>
    <p>Você será redirecionado para o login...</p>
</div>

<script>
setTimeout(function(){
    window.location.href = "index.php";
}, 2500);
</script>

</body>
</html>