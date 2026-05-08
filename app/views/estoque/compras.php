<h2>Compras</h2>

<a href="<?= BASE_URL ?>/compras/criar" class="btn btn-primary">
    + Nova Compra
</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fornecedor</th>
            <th>Data</th>
            <th>Total</th>
            <th>Ações</th>

        <td>
        <a href="<?= BASE_URL ?>/compras/ver/<?= $c['id'] ?>" 
           class="btn btn-info btn-sm">
           Ver
        </a>
    </td>

        </tr>
    </thead>

    <tbody>

        <?php if (!empty($compras)): ?>

            <?php foreach ($compras as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['fornecedor'] ?></td>
                    <td><?= date('d/m/Y', strtotime($c['data'])) ?></td>
                    <td>R$ <?= number_format($c['total'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="4">Nenhuma compra registrada.</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>