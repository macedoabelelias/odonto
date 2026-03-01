<?php
require_once("config/conexao.php");

$sql = $pdo->prepare("INSERT INTO produtos
    (fornecedor_id, nome, descricao, estoque, estoque_minimo, valor)
    VALUES (:fornecedor_id, :nome, :descricao, :estoque, :estoque_minimo, :valor)");

$sql->execute([
    ':fornecedor_id' => $_POST['fornecedor_id'],
    ':nome' => $_POST['nome'],
    ':descricao' => $_POST['descricao'],
    ':estoque' => $_POST['estoque'],
    ':estoque_minimo' => $_POST['estoque_minimo'],
    ':valor' => str_replace(',', '.', $_POST['valor'])
]);

header("Location: produtos.php");
exit;