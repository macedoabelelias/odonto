<?php
require_once("config/conexao.php");
require_once("layout/header.php");
require_once("layout/sidebar.php");
require_once("layout/navbar.php");

$sql = $pdo->query("
    SELECT p.*, f.nome as fornecedor_nome 
    FROM produtos p
    INNER JOIN fornecedores f ON p.fornecedor_id = f.id
    ORDER BY p.id DESC
");

$produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Produtos</h4>
        <a href="produto_novo.php" class="btn btn-primary">Novo Produto</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Fornecedor</th>
                <th>Estoque</th>
                <th>Valor</th>
                <th>Status</th>
                <th width="160">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($produtos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= $p['fornecedor_nome'] ?></td>
                <td><?= $p['estoque'] ?></td>
                <td>R$ <?= number_format($p['valor'],2,',','.') ?></td>
                <td><?= $p['status'] ?></td>
                <td>
                    <a href="produto_editar.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="produto_excluir.php?id=<?= $p['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Deseja excluir?')">
                       Excluir
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php require_once("layout/footer.php"); ?>