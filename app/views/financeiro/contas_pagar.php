<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="mb-0">💸 Contas a Pagar</h4>

    <a href="<?= BASE_URL ?>/contasPagar/criar" class="btn btn-danger btn-sm">
        + Nova Conta
    </a>

</div>

<?php $filtroAtual = $_GET['param'] ?? null; ?>

<!-- 🔥 FILTRO CORRETO -->
<div class="mb-3">

    <a href="<?= BASE_URL ?>/contasPagar"
       class="btn btn-sm <?= !$filtroAtual ? 'btn-secondary' : 'btn-outline-secondary' ?>">
        Todas
    </a>

    <a href="<?= BASE_URL ?>/contasPagar/index/pendente"
       class="btn btn-sm <?= $filtroAtual=='pendente' ? 'btn-warning' : 'btn-outline-warning' ?>">
        Pendentes
    </a>

    <a href="<?= BASE_URL ?>/contasPagar/index/pago"
       class="btn btn-sm <?= $filtroAtual=='pago' ? 'btn-success' : 'btn-outline-success' ?>">
        Pagas
    </a>

    <a href="<?= BASE_URL ?>/contasPagar/index/vencidas"
       class="btn btn-sm <?= $filtroAtual=='vencidas' ? 'btn-danger' : 'btn-outline-danger' ?>">
        Vencidas
    </a>

</div>


<!-- 🔥 RESUMO -->
<div class="row mb-4">

<div class="col-md-4">
<div class="card shadow-sm text-center p-3">
<h6>💸 Pago Hoje</h6>
<h4 class="text-danger">
R$ <?= number_format($resumo['hoje'],2,',','.') ?>
</h4>
</div>
</div>

<div class="col-md-4">
<div class="card shadow-sm text-center p-3">
<h6>📌 Pendente</h6>
<h4 class="text-warning">
R$ <?= number_format($resumo['pendente'],2,',','.') ?>
</h4>
</div>
</div>

<div class="col-md-4">
<div class="card shadow-sm text-center p-3">
<h6>🔴 Vencidas</h6>
<h4 class="text-danger">
R$ <?= number_format($resumo['vencidas'],2,',','.') ?>
</h4>
</div>
</div>

</div>


<!-- 🔥 TABELA -->
<div class="card shadow-sm">
<div class="card-body">

<table class="table table-sm table-hover">

<thead class="table-light">
<tr>
<th>Descrição</th>
<th>Valor</th>
<th>Vencimento</th>
<th>Status</th>
<th width="220">Ação</th>
</tr>
</thead>

<tbody>

<?php foreach($contas as $c): ?>

<?php 
$hoje = date('Y-m-d');

if($c['status'] == 'pendente' && $c['data_vencimento'] < $hoje){
    $classe = 'table-danger';
}elseif($c['data_vencimento'] == $hoje){
    $classe = 'table-warning';
}else{
    $classe = '';
}
?>

<tr class="<?= $classe ?>">

<td><?= htmlspecialchars($c['descricao']) ?></td>

<td><strong>R$ <?= number_format($c['valor'],2,',','.') ?></strong></td>

<td><?= date('d/m/Y', strtotime($c['data_vencimento'])) ?></td>

<td>
<?php if($c['status']=='pendente'): ?>
<span class="badge bg-warning text-dark">Pendente</span>
<?php else: ?>
<span class="badge bg-success">Pago</span>
<?php endif; ?>
</td>

<td>

<?php if($c['status']=='pendente'): ?>

<div class="d-flex gap-1">

<form method="POST" action="<?= BASE_URL ?>/contasPagar/pagar/<?= $c['id'] ?>" class="d-flex gap-1">

<select name="forma_pagamento" class="form-select form-select-sm">
<option value="dinheiro">Dinheiro</option>
<option value="pix">PIX</option>
<option value="cartao">Cartão</option>
<option value="transferencia">Transferência</option>
</select>

<button class="btn btn-danger btn-sm">💸</button>

</form>

<a href="<?= BASE_URL ?>/contasPagar/excluir/<?= $c['id'] ?>" 
   class="btn btn-sm btn-outline-danger"
   onclick="return confirm('Deseja excluir esta conta?')">
   🗑
</a>

</div>

<?php else: ?>

<div class="d-flex gap-1">
<span class="text-muted">—</span>

<a href="<?= BASE_URL ?>/contasPagar/excluir/<?= $c['id'] ?>" 
   class="btn btn-sm btn-outline-danger">
   🗑
</a>
</div>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>
</div>