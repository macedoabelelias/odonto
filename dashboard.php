<?php
require_once("config/conexao.php");
require_once("layout/header.php");
require_once("layout/sidebar.php");
require_once("layout/navbar.php");

// Mês atual
$mesAtual = date('Y-m');

// TOTAL RECEBIDO NO MÊS
$recebido = $pdo->query("
    SELECT SUM(valor) as total 
    FROM financeiro 
    WHERE tipo='Receita' 
    AND DATE_FORMAT(data, '%Y-%m') = '$mesAtual'
")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// TOTAL PAGO NO MÊS
$pago = $pdo->query("
    SELECT SUM(valor) as total 
    FROM financeiro 
    WHERE tipo='Despesa' 
    AND DATE_FORMAT(data, '%Y-%m') = '$mesAtual'
")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// TOTAL COMPRAS NO MÊS
$compras = $pdo->query("
    SELECT SUM(valor_total) as total 
    FROM compras 
    WHERE DATE_FORMAT(data_compra, '%Y-%m') = '$mesAtual'
")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// TOTAL PACIENTES
$pacientes = $pdo->query("SELECT COUNT(*) as total FROM pacientes")
                 ->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// PRODUTOS COM ESTOQUE BAIXO
$estoqueBaixo = $pdo->query("
    SELECT * FROM produtos 
    WHERE estoque <= estoque_minimo
")->fetchAll(PDO::FETCH_ASSOC);

// GRÁFICO ÚLTIMOS 6 MESES
$grafico = $pdo->query("
    SELECT 
        DATE_FORMAT(data, '%m/%Y') as mes,
        SUM(CASE WHEN tipo='Receita' THEN valor ELSE 0 END) as receita,
        SUM(CASE WHEN tipo='Despesa' THEN valor ELSE 0 END) as despesa
    FROM financeiro
    WHERE data >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(data, '%Y-%m')
    ORDER BY data ASC
")->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$receitas = [];
$despesas = [];

foreach($grafico as $g){
    $labels[] = $g['mes'];
    $receitas[] = $g['receita'];
    $despesas[] = $g['despesa'];
}
?>

<div class="content-card">

    <h4 class="mb-4">Dashboard</h4>

    <!-- CARDS -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card text-white bg-success p-3">
                <h6>Recebido no Mês</h6>
                <h4>R$ <?= number_format($recebido,2,',','.') ?></h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger p-3">
                <h6>Pago no Mês</h6>
                <h4>R$ <?= number_format($pago,2,',','.') ?></h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary p-3">
                <h6>Compras no Mês</h6>
                <h4>R$ <?= number_format($compras,2,',','.') ?></h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-dark p-3">
                <h6>Total de Pacientes</h6>
                <h4><?= $pacientes ?></h4>
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

<?php require_once("layout/footer.php"); ?>