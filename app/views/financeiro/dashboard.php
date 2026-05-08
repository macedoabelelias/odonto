<?php
$nivel = $_SESSION['usuario_nivel'] ?? '';
?>

<style>
.dashboard-card{ border-radius:12px; padding:12px; }
.card-blue{ background:#eef5ff; }
.card-green{ background:#eefaf3; }
.card-red{ background:#fff0f0; }
.card-yellow{ background:#fff8e6; }
.card-purple{ background:#f3e8ff; }

canvas {
    max-height: 250px !important;
}
</style>

<h4 class="mb-4">📊 Dashboard Financeiro</h4>

<!-- ======================
CARDS (RECEBER)
====================== -->

<div class="row g-3 mb-4">

<div class="col-md-3">
<div class="card dashboard-card card-blue text-center">
<small>💰 Receber Hoje</small>
<strong>R$ <?= number_format((float)($contasReceberHoje ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-green text-center">
<small>💰 Recebido Hoje</small>
<strong>R$ <?= number_format((float)($recebidoHoje ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-red text-center">
<small>📌 Em Aberto</small>
<strong>R$ <?= number_format((float)($totalAberto ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-purple text-center">
<small>📊 Saldo</small>
<strong>R$ <?= number_format((float)($saldo ?? 0),2,',','.') ?></strong>
</div>
</div>

</div>

<!-- ======================
CONTAS A PAGAR (CORRIGIDO)
====================== -->

<div class="row g-3 mb-4">

<div class="col-md-3">
<div class="card dashboard-card card-yellow text-center">
<small>💸 Vencem Hoje</small>
<strong>R$ <?= number_format((float)($pagarHoje ?? 0),2,',','.') ?></strong>

<!-- <?php if(($pagarHoje ?? 0) == 0): ?>
<small class="text-muted d-block">Sem vencimentos hoje</small>
<?php endif; ?> -->

</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-green text-center">
<small>💸 Pago Hoje</small>
<strong>R$ <?= number_format((float)($pagoHoje ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-red text-center">
<small>📌 Total a Pagar</small>
<strong>R$ <?= number_format((float)($totalPagar ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-red text-center">
<small>🔴 Vencidas</small>
<strong>R$ <?= number_format((float)($vencidas ?? 0),2,',','.') ?></strong>

<?php if(($vencidas ?? 0) > 0): ?>
<small class="text-danger d-block">⚠ Atrasadas</small>
<?php endif; ?>

</div>
</div>

</div>

<!-- ======================
GRÁFICOS
====================== -->

<div class="row mt-4">

    <!-- 📊 PRODUÇÃO -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 p-3">
            <h6 class="mb-3">📊 Produção Mensal</h6>

            <?php if(array_sum($grafico ?? []) == 0): ?>
                <p class="text-muted text-center">Sem dados ainda</p>
            <?php endif; ?>

            <canvas id="graficoMensal"></canvas>
        </div>
    </div>

    <!-- 📈 COMPARATIVO -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 p-3">
            <h6 class="mb-3">📈 Receita x Despesa</h6>
            <canvas id="graficoComparativo"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- 📊 PRODUÇÃO -->
<script>
new Chart(document.getElementById('graficoMensal'), {
    type: 'bar',
    data: {
        labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        datasets: [{
            label: 'Receita',
            data: <?= json_encode($grafico ?? array_fill(0,12,0)) ?>,
            backgroundColor: '#0d6efd',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<!-- 📈 COMPARATIVO -->
<script>
new Chart(document.getElementById('graficoComparativo'), {
    type: 'line',
    data: {
        labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        datasets: [
            {
                label: 'Receitas',
                data: <?= json_encode($comparativo['receitas'] ?? array_fill(0,12,0)) ?>,
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,0.2)',
                tension: 0.3
            },
            {
                label: 'Despesas',
                data: <?= json_encode($comparativo['despesas'] ?? array_fill(0,12,0)) ?>,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220,53,69,0.2)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>