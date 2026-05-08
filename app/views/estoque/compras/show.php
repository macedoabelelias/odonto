<div class="card">

    <h2>🧾 Detalhes da Compra</h2>

    <p><strong>Fornecedor:</strong> <?= $compra['fornecedor'] ?></p>
    <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($compra['data'])) ?></p>

    <hr>

    <table width="100%" border="0" cellspacing="0" cellpadding="8">

        <thead style="background:#f1f1f1;">
            <tr>
                <th align="left">Produto</th>
                <th align="center">Qtd</th>
                <th align="right">Custo</th>
                <th align="right">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($itens as $item): ?>
            <tr style="border-bottom:1px solid #ddd;">
                <td><?= $item['produto'] ?></td>

                <td align="center">
                    <?= $item['quantidade'] ?>
                </td>

                <td align="right">
                    R$ <?= number_format($item['custo'], 2, ',', '.') ?>
                </td>

                <td align="right">
                    R$ <?= number_format($item['quantidade'] * $item['custo'], 2, ',', '.') ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <div style="text-align:right; margin-top:15px; font-size:18px;">
        <strong>Total: R$ <?= number_format($compra['valor_total'], 2, ',', '.') ?></strong>
    </div>

    <div style="margin-top:20px; display:flex; gap:10px;">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir</button>
        <a href="/odonto/public/compras" class="btn btn-secondary">Voltar</a>
    </div>

</div>

<style>
@media print {

    body * {
        visibility: hidden;
    }

    .card, .card * {
        visibility: visible;
    }

    .card {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    button, a {
        display: none;
    }
}
</style>