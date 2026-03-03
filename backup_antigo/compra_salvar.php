<?php
require_once("config/conexao.php");

$fornecedor_id = $_POST['fornecedor_id'];
$produto_id = $_POST['produto_id'];
$quantidade = $_POST['quantidade'];
$valor_unitario = str_replace(',', '.', $_POST['valor_unitario']);
$data_compra = $_POST['data_compra'];

$valor_total = $quantidade * $valor_unitario;

try {

    $pdo->beginTransaction();

    // Inserir compra
    $sql = $pdo->prepare("INSERT INTO compras
        (fornecedor_id, produto_id, quantidade, valor_unitario, valor_total, data_compra)
        VALUES (:fornecedor_id, :produto_id, :quantidade, :valor_unitario, :valor_total, :data_compra)");

    $sql->execute([
        ':fornecedor_id' => $fornecedor_id,
        ':produto_id' => $produto_id,
        ':quantidade' => $quantidade,
        ':valor_unitario' => $valor_unitario,
        ':valor_total' => $valor_total,
        ':data_compra' => $data_compra
    ]);

  // GERAR CONTA A PAGAR AUTOMÁTICA

    $sqlFinanceiro = $pdo->prepare("
        INSERT INTO financeiro 
        (descricao, tipo, valor, data, vencimento, status, referencia_id, referencia_tipo)
        VALUES 
        (:descricao, 'Despesa', :valor, CURDATE(), :vencimento, 'Pendente', :ref_id, 'compra')
    ");

    $sqlFinanceiro->execute([
        ':descricao' => 'Compra de estoque',
        ':valor' => $valor_total,
        ':vencimento' => $data_compra,
        ':ref_id' => $pdo->lastInsertId()
    ]);

    // Atualizar estoque
    $sqlEstoque = $pdo->prepare("
        UPDATE produtos 
        SET estoque = estoque + :quantidade 
        WHERE id = :produto_id
    ");

    $sqlEstoque->execute([
        ':quantidade' => $quantidade,
        ':produto_id' => $produto_id
    ]);

    $pdo->commit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erro: " . $e->getMessage();
    exit;
}

header("Location: compras.php");
exit;