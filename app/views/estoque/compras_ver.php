<h2>Detalhes da Compra #<?= $compra['id'] ?></h2>

<div class="mb-3">
    <strong>Fornecedor:</strong> <?= $compra['fornecedor'] ?><br>
    <strong>Data:</strong> <?= date('d/m/Y', strtotime($compra['data'])) ?><br>
    <strong>Total:</strong> R$ <?= number_format($compra['total'], 2, ',', '.') ?>
</div>

<hr>

<h4>Itens</h4>

<table class="table">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($itens as $i): ?>
            <tr>
                <td><?= $i['produto'] ?></td>
                <td><?= $i['quantidade'] ?></td>
                <td>R$ <?= number_format($i['preco'], 2, ',', '.') ?></td>
                <td>
                    R$ <?= number_format($i['quantidade'] * $i['preco'], 2, ',', '.') ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= BASE_URL ?>/compras" class="btn btn-secondary">Voltar</a>