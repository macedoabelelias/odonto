<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

$id = $_GET['id'] ?? null;

if($id){
    $sql = $pdo->prepare("DELETE FROM pacientes WHERE id = ?");
    $sql->execute([$id]);
}

header("Location: pacientes.php");
exit;