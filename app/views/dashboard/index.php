<?php
$nivel = $_SESSION['usuario_nivel'] ?? '';
?>

<div class="content-card">

<h4 class="mb-4">Dashboard</h4>

<!-- =========================
CARDS PRINCIPAIS (TODOS VEEM)
========================= -->

<?php
$nivel = $_SESSION['usuario_nivel'] ?? '';
?>

<div class="row g-3 mb-4">

<!-- CONSULTAS HOJE -->
<div class="col-lg-3 col-md-6">
<div class="card shadow-sm text-center" style="background:#eef5ff;">
<div class="card-body">
<h6 style="color:#2563eb;">Consultas Hoje</h6>
<h3><?= count($consultasHoje ?? []) ?></h3>
</div>
</div>
</div>

<!-- ATENDIDOS HOJE -->
<div class="col-lg-3 col-md-6">
<div class="card shadow-sm text-center" style="background:#eafaf1;">
<div class="card-body">
<h6 style="color:#16a34a;">Atendidos Hoje</h6>
<h3><?= $atendidosHoje ?? 0 ?></h3>
</div>
</div>
</div>

<?php if($nivel == 'admin' || $nivel == 'administrador'){ ?>

<!-- FATURAMENTO (SÓ ADMIN) -->
<div class="col-lg-3 col-md-6">
<div class="card shadow-sm text-center" style="background:#fff8e6;">
<div class="card-body">
<h6 style="color:#f59e0b;">Faturamento Hoje</h6>
<h3>R$ <?= number_format($faturamentoHoje ?? 0,2,",",".") ?></h3>
</div>
</div>
</div>

<?php } ?>

<!-- ANIVERSARIANTES -->
<div class="col-lg-3 col-md-6">
<div class="card shadow-sm text-center" style="background:#fde8ef;">
<div class="card-body">
<h6 style="color:#ec4899;">Aniversariantes</h6>
<h3><?= count($aniversariantes ?? []) ?></h3>
</div>
</div>
</div>

</div>


<!-- =========================
AGENDA (DENTISTA E RECEPÇÃO)
========================= -->

<?php if($nivel == 'dentista' || $nivel == 'recepcionista'){ ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h5>📅 Agenda de Hoje</h5>

<?php if(!empty($consultasHoje)){ ?>

<table class="table table-sm">

<tr>
<th>Hora</th>
<th>Paciente</th>
<th>Procedimento</th>
</tr>

<?php foreach($consultasHoje as $c){ ?>

<tr>
<td><?= $c['hora'] ?></td>
<td><?= htmlspecialchars($c['paciente']) ?></td>
<td><?= htmlspecialchars($c['procedimento'] ?? '-') ?></td>
</tr>

<?php } ?>

</table>

<?php }else{ ?>

<div class="alert alert-light">
Nenhuma consulta hoje
</div>

<?php } ?>

</div>
</div>

<?php } ?>


<!-- =========================
PRÓXIMAS CONSULTAS (RECEPÇÃO)
========================= -->

<?php if($nivel == 'recepcionista'){ ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h5>⏰ Próximas Consultas</h5>

<?php if(!empty($proximasConsultas)){ ?>

<ul class="list-group">

<?php foreach($proximasConsultas as $c){ ?>

<li class="list-group-item">

<strong><?= $c['hora'] ?></strong> -  
<?= htmlspecialchars($c['paciente']) ?>

</li>

<?php } ?>

</ul>

<?php } else { ?>

<div class="text-muted">
Nenhuma consulta agendada
</div>

<?php } ?>

</div>
</div>

<?php } ?>


<!-- =========================
ANIVERSARIANTES (DENTISTA E RECEPÇÃO)
========================= -->

<?php if($nivel == 'dentista' || $nivel == 'recepcionista'){ ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h5>🎂 Aniversariantes Hoje</h5>

<?php if(!empty($aniversariantes)){ ?>

<ul class="list-group">

<?php foreach($aniversariantes as $p){ ?>

<li class="list-group-item">
<?= htmlspecialchars($p['nome']) ?>
</li>

<?php } ?>

</ul>

<?php } else { ?>

<div class="text-muted">
Nenhum aniversariante hoje
</div>

<?php } ?>

</div>
</div>

<?php } ?>


<!-- =========================
FINANCEIRO
========================= -->

<?php if($nivel == 'financeiro'){ ?>

<div class="row g-3 mb-4">

<div class="col-md-4">
<div class="card shadow-sm bg-success text-white">
<div class="card-body">
<h6>Recebido Hoje</h6>
<h3>R$ <?= number_format($recebidoHoje ?? 0,2,",",".") ?></h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow-sm bg-warning">
<div class="card-body">
<h6>Contas a Receber Hoje</h6>
<h3><?= $contasHoje ?? 0 ?></h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow-sm bg-danger text-white">
<div class="card-body">
<h6>Contas Vencidas</h6>
<h3><?= $contasVencidas ?? 0 ?></h3>
</div>
</div>
</div>

</div>

<?php } ?>


<!-- =========================
ADMINISTRADOR
========================= -->

<?php if($nivel == 'admin' || $nivel == 'administrador'){ ?>

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
<h3><?= $pacientes ?? 0 ?></h3>
</div>
</div>

</div>


<h5 class="mb-3">⚠ Produtos com Estoque Baixo</h5>

<?php if(!empty($estoqueBaixo)){ ?>

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

<?php foreach($estoqueBaixo as $p){ ?>

<tr>
<td><?= htmlspecialchars($p['nome']) ?></td>
<td class="text-danger"><?= $p['estoque'] ?></td>
<td><?= $p['estoque_minimo'] ?></td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

<?php }else{ ?>

<div class="alert alert-success mb-4">
Nenhum produto com estoque baixo 🎉
</div>

<?php } ?>

<hr class="my-5">

<div class="card shadow-sm border-0 p-4">

<h5 class="mb-3">📊 Faturamento dos Últimos 6 Meses</h5>

<canvas id="graficoFinanceiro" height="100"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('graficoFinanceiro');

new Chart(ctx, {

type: 'bar',

data: {

labels: <?= json_encode($labels ?? []) ?>,

datasets: [

{
label: 'Receitas',
data: <?= json_encode($receitas ?? []) ?>,
backgroundColor: '#28a745'
},

{
label: 'Despesas',
data: <?= json_encode($despesas ?? []) ?>,
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

<?php } ?>

</div>