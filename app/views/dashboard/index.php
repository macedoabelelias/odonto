<?php
$nivel = strtolower(trim($_SESSION['usuario_nivel'] ?? ''));
?>

<style>
.dashboard-card{ border-radius:12px; padding:12px; }
.card-blue{ background:#eef5ff; }
.card-green{ background:#eefaf3; }
.card-red{ background:#fff0f0; }
.card-yellow{ background:#fff8e6; }
.card-purple{ background:#f3e8ff; }
</style>

<h4 class="mb-4">📊 Painel Administrativo</h4>

<?php if(!empty($estoqueBaixo)): ?>

<div style="background:#fff3cd; border:1px solid #ffeeba; padding:12px; border-radius:8px; margin-bottom:15px;">
    
    <strong>⚠️ Produtos com estoque baixo:</strong>

    <ul style="margin:8px 0 0 15px;">
        <?php foreach($estoqueBaixo as $p): ?>
            <li>
                <?= $p['nome'] ?> 
                (<?= $p['estoque'] ?> em estoque)
            </li>
        <?php endforeach; ?>
    </ul>

</div>

<?php endif; ?>

<!-- ======================
LINHA 1 (BASE - TODOS)
====================== -->
<div class="row g-2 mb-2">

<div class="col-md-3">
<div class="card dashboard-card card-blue text-center">
<small>💰 Receber Hoje</small>
<strong>R$ <?= number_format((float)($contasReceberHoje ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-green text-center">
<small>💵 Recebido Hoje</small>
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
FINANCEIRO (ADMIN / FINANCEIRO)
====================== -->
<?php if(in_array($nivel, ['administrador','financeiro'])): ?>

<div class="row g-2 mb-2">

<div class="col-md-4">
<div class="card dashboard-card card-yellow text-center">
<small>💸 Pagar Hoje</small>
<strong>R$ <?= number_format((float)($pagarHoje ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-4">
<div class="card dashboard-card card-green text-center">
<small>💳 Pago Hoje</small>
<strong>R$ <?= number_format((float)($pagoHoje ?? 0),2,',','.') ?></strong>
</div>
</div>

<div class="col-md-4">
<div class="card dashboard-card card-red text-center">
<small>📉 Total a Pagar</small>
<strong>R$ <?= number_format((float)($totalPagar ?? 0),2,',','.') ?></strong>
</div>
</div>

</div>

<?php endif; ?>


<!-- ======================
CLÍNICA (ADMIN + RECEPÇÃO)
====================== -->
<div class="row g-2 mb-2">

<div class="col-md-3">
<div class="card dashboard-card card-blue text-center">
<small>📅 Consultas Hoje</small>
<strong><?= (int)($consultasHoje ?? 0) ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-green text-center">
<small>✅ Atendidos Hoje</small>
<strong><?= (int)($atendidosHoje ?? 0) ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-purple text-center">
<small>🎂 Aniversários Hoje</small>
<strong><?= (int)($aniversariantesHoje ?? 0) ?></strong>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-yellow text-center">
<small>🎉 Aniversários do Mês</small>
<strong><?= (int)($aniversariantesMes ?? 0) ?></strong>
</div>
</div>

<!-- ======================
DENTISTA (VISÃO INDIVIDUAL)
====================== -->
<?php if($nivel == 'dentista'): ?>

<div class="row g-2 mb-2">

    <div class="col-md-3">
        <div class="card dashboard-card card-green text-center">
            <small>👥 Meus Pacientes</small>
            <strong><?= (int)($meusPacientes ?? 0) ?></strong>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card card-yellow text-center">
            <small>💼 Comissões Hoje</small>
            <strong>R$ <?= number_format((float)($comissoesHoje ?? 0),2,',','.') ?></strong>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card card-green text-center">
            <small>💼 Comissões Pagas</small>
            <strong>R$ <?= number_format((float)($comissoesPagas ?? 0),2,',','.') ?></strong>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card card-purple text-center">
            <small>📊 Total Comissões</small>
            <strong>R$ <?= number_format((float)($totalComissoes ?? 0),2,',','.') ?></strong>
        </div>
    </div>

</div>

<!-- 🔥 SOMENTE 1 RANKING PARA DENTISTA -->
<div class="row g-2 mt-3">
    <div class="col-md-6" >
        <div class="card card-modern h-100" >
            <h5 class="mb-3">🏆 Meus Procedimentos</h5>
            <div style="height:250px;">
                <canvas id="graficoRanking"></canvas>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>


<!-- ======================
GRÁFICOS (ADMIN)
====================== -->
<?php if($nivel != 'dentista'): ?>

<div class="row g-2 mt-3">

    <div class="col-md-6">
        <div class="card card-modern h-100">
            <h5 class="mb-3">📊 Receita Mensal</h5>
            <div style="height:250px;">
                <canvas id="graficoFinanceiro"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-modern h-100">
            <h5 class="mb-3">📊 Receita vs Despesa</h5>
            <div style="height:250px;">
                <canvas id="graficoComparativo"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- 🔥 LUCRO + RANKING LADO A LADO -->
<div class="row g-2 mt-3">

    <div class="col-md-6">
        <div class="card card-modern h-100">
            <h5 class="mb-3">💰 Lucro Mensal</h5>
            <div style="height:250px;">
                <canvas id="graficoLucro"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-modern h-100">
            <h5 class="mb-3">🏆 Ranking de Procedimentos</h5>
            <div style="height:250px;">
                <canvas id="graficoRanking"></canvas>
            </div>
        </div>
    </div>

</div>

<?php endif; ?>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

// =========================
// RECEITA
// =========================
const ctx1 = document.getElementById('graficoFinanceiro');
if(ctx1){
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            datasets: [{
                label: 'Receita',
                data: <?= json_encode($grafico ?? array_fill(0,12,0)) ?>,
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive:true, maintainAspectRatio:false }
    });
}

// =========================
// COMPARATIVO
// =========================
const ctx2 = document.getElementById('graficoComparativo');
if(ctx2){
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            datasets: [
                { label: 'Receita', data: <?= json_encode($graficoComparativo['receitas'] ?? array_fill(0,12,0)) ?> },
                { label: 'Despesas', data: <?= json_encode($graficoComparativo['despesas'] ?? array_fill(0,12,0)) ?> }
            ]
        },
        options: { responsive:true, maintainAspectRatio:false }
    });
}

// =========================
// LUCRO
// =========================
const ctx3 = document.getElementById('graficoLucro');
if(ctx3){
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            datasets: [{
                label: 'Lucro',
                data: <?= json_encode($lucro ?? array_fill(0,12,0)) ?>,
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive:true, maintainAspectRatio:false }
    });
}

// =========================
// RANKING (FINAL)
// =========================
const ctx4 = document.getElementById('graficoRanking');

if(ctx4){

    const rankingData = <?= json_encode($rankingDentistas ?? []) ?>;

    console.log("Ranking:", rankingData);

    const labelsRanking = rankingData.map(item => item.procedimento);
    const valoresRanking = rankingData.map(item => item.total);

    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: labelsRanking,
            datasets: [{
                label: 'Quantidade',
                data: valoresRanking
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y'
        }
    });

}

});
</script>