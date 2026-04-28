<div class="container mt-4">

    <h4 class="mb-3">👨‍⚕️ Comissões</h4>

    <!-- FILTRO -->
    <form method="GET" class="mb-3 d-flex gap-2 align-items-end">
        <div>
            <label>Início</label>
            <input type="date" name="inicio" value="<?= $inicio ?>" class="form-control form-control-sm">
        </div>

        <div>
            <label>Fim</label>
            <input type="date" name="fim" value="<?= $fim ?>" class="form-control form-control-sm">
        </div>

        <div>
            <button class="btn btn-primary btn-sm">Filtrar</button>
        </div>
    </form>

    <!-- TOTAL -->
    <div class="card shadow-sm mb-3 p-3 text-center">
        <h6 class="mb-1">Total no período</h6>
        <h3 class="text-success mb-0">
            R$ <?= number_format($total,2,',','.') ?>
        </h3>
    </div>

    <!-- TABELA -->
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>Profissional</th>
                    <th>Valor</th>
                    <th>%</th>
                    <th>Comissão</th>
                    <th>Data</th>
                </tr>
            </thead>

            <tbody>

                <?php if(!empty($comissoes)): ?>

                    <?php foreach($comissoes as $c): ?>

                        <tr>
                            <!-- 🔥 AQUI ESTAVA O ERRO -->
                            <td><?= $c['dentista'] ?? '<span class="text-danger">Não vinculado</span>' ?></td>

                            <td>R$ <?= number_format($c['valor_procedimento'],2,',','.') ?></td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= $c['percentual'] ?>%
                                </span>
                            </td>

                            <td class="text-success fw-bold">
                                R$ <?= number_format($c['valor_comissao'],2,',','.') ?>
                            </td>

                            <td><?= date('d/m/Y', strtotime($c['data'])) ?></td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Nenhuma comissão encontrada
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>