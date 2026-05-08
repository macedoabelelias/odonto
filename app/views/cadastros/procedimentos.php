<h2>Procedimentos</h2>

<a href="<?= BASE_URL ?>/procedimentos/criar" class="btn btn-primary">
    + Novo Procedimento
</a>

<table class="table table-striped table-hover mt-3 align-middle">

    <thead class="table-light">
        <tr>
            <th style="width:30%;">Nome</th>
            <th style="width:10%; text-align:center;">Ícone</th>
            <th style="width:15%;">Código</th>
            <th style="width:15%;">Valor</th>
            <th style="width:20%;">Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($procedimentos)): ?>
            <?php foreach($procedimentos as $p): ?>

                <?php
                    $icone = $p['icone'] ?? '';

                    // 🔥 CAMINHO PADRÃO (ÚNICO)
                    $caminhoFisico = BASE_PATH . "/public/assets/img/procedimentos/" . $icone;
                    $caminhoWeb = BASE_URL . "/assets/img/procedimentos/" . $icone;

                    $iconeExiste = (!empty($icone) && file_exists($caminhoFisico));
                ?>

                <tr>

                    <!-- NOME -->
                    <td><?= htmlspecialchars($p['nome']) ?></td>

                    <!-- ÍCONE -->
                    <td style="text-align:center;">

                        <?php if ($iconeExiste): ?>
                            
                            <img src="<?= $caminhoWeb ?>" 
                                 title="<?= htmlspecialchars($p['nome']) ?>"
                                 style="
                                    width:36px;
                                    height:36px;
                                    object-fit:contain;
                                    border-radius:8px;
                                    background:#f8f9fa;
                                    padding:4px;
                                 ">

                        <?php else: ?>

                            <img src="<?= BASE_URL ?>/assets/img/procedimentos/padrao.png"
                                 title="Sem ícone"
                                 style="
                                    width:36px;
                                    height:36px;
                                    opacity:0.5;
                                 ">

                        <?php endif; ?>

                    </td>

                    <!-- CÓDIGO -->
                    <td><?= htmlspecialchars($p['codigo_tuss'] ?? '-') ?></td>

                    <!-- VALOR -->
                    <td>
                        R$ <?= number_format($p['valor_particular'] ?? 0, 2, ',', '.') ?>
                    </td>

                    <!-- AÇÕES -->
                    <td>
                        <a href="<?= BASE_URL ?>/procedimentos/editar/<?= $p['id'] ?>" 
                           class="btn btn-warning btn-sm">
                           ✏️ Editar
                        </a>

                        <form action="<?= BASE_URL ?>/procedimentos/excluir/<?= $p['id'] ?>" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('Excluir procedimento?')">

                            <button type="submit" class="btn btn-danger btn-sm">
                                🗑️ Excluir
                            </button>
                        </form>
                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="5">Nenhum procedimento cadastrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>

</table>