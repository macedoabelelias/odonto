<?php
$nivel = $_SESSION['usuario_nivel'] ?? '';
?>

<style>

.dashboard-card{
border-radius:12px;
}

.card-blue{ background:#eef5ff; }
.card-green{ background:#eefaf3; }
.card-red{ background:#fff0f0; }
.card-yellow{ background:#fff8e6; }
.card-cyan{ background:#eef9ff; }

</style>

<h4 class="mb-4">Dashboard</h4>

<!-- ======================
CARDS SUPERIORES
====================== -->

<div class="row g-3 mb-4">

<div class="col-md-4">
<div class="card dashboard-card card-blue shadow-sm border-0">
<div class="card-body text-center">

<h6 class="text-muted">Contas a Receber Hoje</h6>

<h3 class="fw-bold text-primary">
R$ <?= number_format($contasReceberHoje ?? 0,2,',','.') ?>
</h3>

</div>
</div>
</div>


<div class="col-md-4">
<div class="card dashboard-card card-green shadow-sm border-0">
<div class="card-body text-center">

<h6 class="text-muted">Recebido Hoje</h6>

<h3 class="fw-bold text-success">
R$ <?= number_format($recebidoHoje ?? 0,2,',','.') ?>
</h3>

</div>
</div>
</div>


<div class="col-md-4">
<div class="card dashboard-card card-red shadow-sm border-0">
<div class="card-body text-center">

<h6 class="text-muted">Total em Aberto</h6>

<h3 class="fw-bold text-danger">
R$ <?= number_format($totalAberto ?? 0,2,',','.') ?>
</h3>

</div>
</div>
</div>

</div>


<div class="row g-3 mb-4">

<div class="col-md-4">
<div class="card dashboard-card card-cyan shadow-sm border-0">
<div class="card-body text-center">

<h6 class="text-muted">Consultas Hoje</h6>

<h2 class="fw-bold"><?= $consultasHoje ?? 0 ?></h2>

</div>
</div>
</div>


<div class="col-md-4">
<div class="card dashboard-card card-green shadow-sm border-0">
<div class="card-body text-center">

<h6 class="text-muted">Atendidos Hoje</h6>

<h2 class="fw-bold"><?= $atendidosHoje ?? 0 ?></h2>

</div>
</div>
</div>


<div class="col-md-4">
<div class="card dashboard-card card-yellow shadow-sm border-0">
<div class="card-body text-center">

<h6 class="text-muted">Aniversariantes</h6>

<h2 class="fw-bold"><?= count($aniversariantes ?? []) ?></h2>

</div>
</div>
</div>

</div>


<!-- ======================
AGENDA DO DIA
====================== -->

<div class="card shadow-sm mb-4">

<div class="card-header bg-white fw-semibold">
<i class="bi bi-calendar3 text-primary me-2"></i>
Agenda de Hoje
</div>

<div class="card-body">

<?php if(empty($agendaHoje)): ?>

<div class="text-muted">
Nenhuma consulta hoje
</div>

<?php else: ?>

<ul class="list-group">

<?php foreach($agendaHoje as $consulta): ?>

<li class="list-group-item d-flex justify-content-between">

<span>
<strong><?= $consulta['hora'] ?></strong>
- <?= htmlspecialchars($consulta['paciente']) ?>
</span>

<span class="badge bg-secondary">
<?= $consulta['procedimento'] ?>
</span>

</li>

<?php endforeach; ?>

</ul>

<?php endif; ?>

</div>

</div>


<!-- ======================
PRÓXIMAS CONSULTAS
====================== -->

<?php if($nivel == 'recepcionista'): ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h5>⏰ Próximas Consultas</h5>

<?php if(!empty($proximasConsultas)): ?>

<ul class="list-group">

<?php foreach($proximasConsultas as $c): ?>

<li class="list-group-item">
<strong><?= $c['hora'] ?></strong> -
<?= htmlspecialchars($c['paciente']) ?>
</li>

<?php endforeach; ?>

</ul>

<?php else: ?>

<div class="text-muted">
Nenhuma consulta agendada
</div>

<?php endif; ?>

</div>
</div>

<?php endif; ?>


<!-- ======================
ANIVERSARIANTES
====================== -->

<?php if($nivel == 'dentista' || $nivel == 'recepcionista'): ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h5>🎂 Aniversariantes Hoje</h5>

<?php if(!empty($aniversariantes)): ?>

<ul class="list-group">

<?php foreach($aniversariantes as $p): ?>

<li class="list-group-item">
<?= htmlspecialchars($p['nome']) ?>
</li>

<?php endforeach; ?>

</ul>

<?php else: ?>

<div class="text-muted">
Nenhum aniversariante hoje
</div>

<?php endif; ?>

</div>

</div>

<?php endif; ?>


<!-- ======================
GRÁFICO
====================== -->

<div class="card shadow-sm border-0 p-4">

<h5 class="mb-3">📊 Contas a Receber</h5>

<div style="height:180px;">
<canvas id="graficoFinanceiro"></canvas>
</div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('graficoFinanceiro');

new Chart(ctx, {

type:'bar',

data:{
labels:['Seg','Ter','Qua','Qui','Sex','Sab'],
datasets:[{
label:'Contas a Receber',
data:[500,900,700,1200,400,200],
backgroundColor:'#0d6efd'
}]
},

options:{
responsive:true,
maintainAspectRatio:false,
plugins:{
legend:{position:'top'}
}
}
});

</script>