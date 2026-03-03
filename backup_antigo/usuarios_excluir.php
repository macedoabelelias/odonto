<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin();

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
$stmt->execute([$id]);

header("Location: usuarios.php");
exit;