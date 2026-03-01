<?php
require_once("config/conexao.php");

$id = $_GET['id'];

$sql = $pdo->prepare("DELETE FROM fornecedores WHERE id = :id");
$sql->execute([':id' => $id]);

header("Location: fornecedores.php");
exit;