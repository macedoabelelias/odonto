<?php
require_once("config/conexao.php");
require_once("layout/header.php");
require_once("layout/sidebar.php");
require_once("layout/navbar.php");

// Buscar produtos com fornecedor
$sql = $pdo->query("
    SELECT p.*, f.nome AS fornecedor_nome
    FROM produtos p
    INNER JOIN fornecedores f ON p.fornecedor_id = f.id
    ORDER BY p.id DESC
");

$produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Produtos</h4>
        <a href="produto_novo.php" class="btn btn-primary">
            Novo Produto
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Fornecedor</th>
                    <th>Estoque</th>
                    <th>Estoque Mínimo</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($produtos) > 0): ?>
                    <?php foreach($produtos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['nome']) ?></td>
                            <td><?= htmlspecialchars($p['fornecedor_nome']) ?></td>

                            <td>
                                <?php if($p['estoque'] <= $p['estoque_minimo']): ?>
                                    <span class="badge bg-danger">
                                        <?= $p['estoque'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success">
                                        <?= $p['estoque'] ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td><?= $p['estoque_minimo'] ?></td>

                            <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>

                            <td>
                                <?php if($p['status'] == 'Ativo'): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="produto_editar.php?id=<?= $p['id'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <a href="produto_excluir.php?id=<?= $p['id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Deseja excluir este produto?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Nenhum produto cadastrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once("layout/footer.php"); ?>