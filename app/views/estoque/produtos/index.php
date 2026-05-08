<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h3>📦 Produtos</h3>

        <a href="/odonto/public/produtos/criar" class="btn btn-primary">
            + Novo Produto
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Estoque</th>
                <th>Custo</th>
                <th>Fornecedor</th>
                <th style="width:120px;">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php if(!empty($produtos)): ?>
                <?php foreach($produtos as $p): ?>

                    <?php
                        $estoqueBaixo = $p['estoque'] <= $p['estoque_minimo'];
                    ?>

                    <tr>

                        <td>
                            <strong><?= $p['nome'] ?></strong>
                        </td>

                        <td>
                            <?php if($estoqueBaixo): ?>
                                <span class="badge badge-danger">
                                    <?= $p['estoque'] ?>
                                </span>
                            <?php else: ?>
                                <span class="badge badge-success">
                                    <?= $p['estoque'] ?>
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            R$ <?= number_format($p['custo'], 2, ',', '.') ?>
                        </td>

                        <td>
                            <?= $p['fornecedor_nome'] ?? '-' ?>
                        </td>

                        <td>

                            <a href="/odonto/public/produtos/editar/<?= $p['id'] ?>" class="btn btn-primary btn-sm">✏️</a>

                            <a href="/odonto/public/produtos/excluir/<?= $p['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Deseja excluir este produto?')">
                               🗑️
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum produto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>