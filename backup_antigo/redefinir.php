<?php
require 'config/conexao.php';

$token = $_GET['token'] ?? '';

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE token_recuperacao=? AND token_expira > NOW()");
$sql->execute([$token]);
$user = $sql->fetch();

if(!$user){
    die("Token inválido ou expirado");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Redefinir senha</title>
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

.card-reset{
    background:#fff;
    border-radius:20px;
    padding:40px;
    width:400px;
    box-shadow:0 20px 40px rgba(0,0,0,.1);
}

.btn-main{
    background:#6366f1;
    color:#fff;
    border:none;
}
</style>
</head>

<body>

<div class="card-reset">

    <h4 class="mb-4 text-center">Nova senha</h4>

    <form method="POST" action="salvar_nova_senha.php">
        <input type="hidden" name="token" value="<?= $token ?>">

        <input type="password" name="senha" class="form-control mb-3" placeholder="Nova senha" required>

        <button class="btn btn-main w-100">Salvar senha</button>
    </form>

</div>

</body>
</html>