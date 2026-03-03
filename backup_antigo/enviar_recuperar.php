<?php
require 'config/conexao.php';

$email = trim(strtolower($_POST['email'] ?? ''));

if(!$email){
    die("Email vazio");
}

$token = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

$sql = $pdo->prepare("UPDATE usuarios SET token_recuperacao=?, token_expira=? WHERE LOWER(email)=?");
$sql->execute([$token,$expira,$email]);

if($sql->rowCount() > 0){

    header("Location: redefinir.php?token=".$token);
    exit;

}else{
    echo "Email não encontrado";
}