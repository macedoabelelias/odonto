<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h3>🧾 Compras</h3>

        <a href="/odonto/public/compras/criar" class="btn btn-primary">
            + Nova Compra
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fornecedor</th>
                <th>Data</th>
                <th>Total</th>
                <th style="width:140px; text-align:center;">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php if(!empty($compras)): ?>
                <?php foreach($compras as $c): ?>
                    <tr style="height:55px;">
                        <td>#<?= $c['id'] ?></td>
                        <td><?= $c['fornecedor'] ?></td>
                        <td><?= date('d/m/Y', strtotime($c['data'])) ?></td>
                        <td>
                            R$ <?= number_format($c['valor_total'] ?? 0, 2, ',', '.') ?>
                        </td>

                    <td style="text-align:center; white-space:nowrap;">

                        <!-- VER -->
                        <a href="<?= BASE_URL ?>/compras/ver/<?= $c['id'] ?>" 
                        class="btn-acao" 
                        title="Ver">
                            🔍
                        </a>

                        <!-- EDITAR -->
                        <a href="<?= BASE_URL ?>/compras/editar/<?= $c['id'] ?>" 
                        class="btn-acao btn-editar" 
                        title="Editar">
                            ✏️
                        </a>

                        <!-- EXCLUIR -->
                        <a href="<?= BASE_URL ?>/compras/excluir/<?= $c['id'] ?>" 
                        class="btn-acao btn-excluir"
                        onclick="return confirm('Tem certeza que deseja excluir esta compra?')"
                        title="Excluir">
                            🗑️
                        </a>

                    </td>    

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding:15px;">
                        Nenhuma compra cadastrada.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>