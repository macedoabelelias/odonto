<div class="content-card">

<h4 class="mb-4">Dashboard</h4>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-success text-white p-3">
            <h6>Recebido no Mês</h6>
            <h3>R$ <?= number_format($recebido ?? 0,2,',','.') ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-danger text-white p-3">
            <h6>Pago no Mês</h6>
            <h3>R$ <?= number_format($pago ?? 0,2,',','.') ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-primary text-white p-3">
            <h6>Compras no Mês</h6>
            <h3>R$ <?= number_format($compras ?? 0,2,',','.') ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-dark text-white p-3">
            <h6>Total de Pacientes</h6>
            <h3><?= $pacientes ?></h3>
        </div>
    </div>

</div>

    <!-- ALERTA ESTOQUE -->
    <h5 class="mb-3">⚠ Produtos com Estoque Baixo</h5>

    <?php if(count($estoqueBaixo) > 0): ?>

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Estoque Atual</th>
                        <th>Estoque Mínimo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($estoqueBaixo as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['nome']) ?></td>
                            <td class="text-danger"><?= $p['estoque'] ?></td>
                            <td><?= $p['estoque_minimo'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>

        <div class="alert alert-success mb-4">
            Nenhum produto com estoque baixo 🎉
        </div>

    <?php endif; ?>

    <hr class="my-5">

    <!-- GRÁFICO -->
    <div class="card shadow-sm border-0 p-4">

        <h5 class="mb-3">📊 Faturamento dos Últimos 6 Meses</h5>

        <canvas id="graficoFinanceiro" height="100"></canvas>

    </div>


<!-- SCRIPT DO GRÁFICO -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('graficoFinanceiro');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Receitas',
                data: <?= json_encode($receitas) ?>,
                backgroundColor: '#28a745'
            },
            {
                label: 'Despesas',
                data: <?= json_encode($despesas) ?>,
                backgroundColor: '#dc3545'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
</script>

