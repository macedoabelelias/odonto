<div class="container mt-4">

<h4>💰 Caixa</h4>

<form method="GET" class="row g-3 mb-4 align-items-end">

    <div class="col-md-3">
        <label class="form-label">Data Inicial</label>

        <input type="date"
               name="inicio"
               value="<?= $inicio ?>"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Data Final</label>

        <input type="date"
               name="fim"
               value="<?= $fim ?>"
               class="form-control">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            Filtrar
        </button>
    </div>

</form>


<!-- 🔥 RESUMO -->
<div class="row mb-4">

<div class="col-md-4">
<div class="card text-center p-3 shadow-sm">
<h6>Entradas</h6>
<h4 class="text-success">R$ <?= number_format($resumo['entradas'],2,',','.') ?></h4>
</div>
</div>

<div class="col-md-4">
<div class="card text-center p-3 shadow-sm">
<h6>Saídas</h6>
<h4 class="text-danger">R$ <?= number_format($resumo['saidas'],2,',','.') ?></h4>
</div>
</div>

<div class="col-md-4">
<div class="card text-center p-3 shadow-sm">
<h6>Saldo</h6>
<h4 class="<?= $resumo['saldo'] >= 0 ? 'text-success' : 'text-danger' ?>">
R$ <?= number_format($resumo['saldo'],2,',','.') ?>
</h4>
</div>
</div>

</div>


<!-- 🔥 LISTA -->
<div class="card shadow-sm">
<div class="card-body">

<table class="table table-sm">

<thead>
<tr>
<th>Tipo</th>
<th>Descrição</th>
<th>Valor</th>
<th>Data</th>
</tr>
</thead>

<tbody>

<?php foreach($movimentos as $m): ?>

<tr>
<td>
<?php if($m['tipo']=='entrada'): ?>
<span class="badge bg-success">Entrada</span>
<?php else: ?>
<span class="badge bg-danger">Saída</span>
<?php endif; ?>
</td>

<td><?= htmlspecialchars($m['descricao']) ?></td>

<td>
R$ <?= number_format($m['valor'],2,',','.') ?>
</td>

<td><?= date('d/m/Y H:i', strtotime($m['data'])) ?></td>
</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>
</div>

</div>