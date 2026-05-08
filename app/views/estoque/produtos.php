<h2>Produtos</h2>

<a href="<?= BASE_URL ?>/produtos/criar" class="btn btn-primary">
    + Novo Produto
</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
            <th>Estoque</th>
            <th>Custo</th>
            <th>Venda</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $p['codigo'] ?></td>
                    <td><?= $p['estoque'] ?></td>
                    <td>R$ <?= number_format($p['preco_custo'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($p['preco_venda'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Nenhum produto cadastrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>