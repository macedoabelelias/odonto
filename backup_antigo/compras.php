<?php
require_once("config/conexao.php");
require_once("layout/header.php");
require_once("layout/sidebar.php");
require_once("layout/navbar.php");

$sql = $pdo->query("
    SELECT c.*, 
           f.nome as fornecedor_nome,
           p.nome as produto_nome
    FROM compras c
    INNER JOIN fornecedores f ON c.fornecedor_id = f.id
    INNER JOIN produtos p ON c.produto_id = p.id
    ORDER BY c.id DESC
");

$compras = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Compras</h4>
        <a href="compra_nova.php" class="btn btn-primary">Nova Compra</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fornecedor</th>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Total</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($compras as $c): ?>
            <tr>
                <td><?= $c['fornecedor_nome'] ?></td>
                <td><?= $c['produto_nome'] ?></td>
                <td><?= $c['quantidade'] ?></td>
                <td>R$ <?= number_format($c['valor_total'],2,',','.') ?></td>
                <td><?= date('d/m/Y', strtotime($c['data_compra'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php require_once("layout/footer.php"); ?>