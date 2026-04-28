<div class="container mt-4">

<h4>🏆 Ranking de Dentistas</h4>

<form method="GET" class="mb-3 d-flex gap-2 align-items-center">
    <input type="date" name="inicio" value="<?= $inicio ?? '' ?>" class="form-control form-control-sm" style="max-width:150px;">
    <input type="date" name="fim" value="<?= $fim ?? '' ?>" class="form-control form-control-sm" style="max-width:150px;">
    <button class="btn btn-primary btn-sm">Filtrar</button>
</form>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-sm table-striped align-middle">

<thead>
<tr>
<th>#</th>
<th>Profissional</th>
<th>Produção</th>
<th>Comissão</th>
</tr>
</thead>

<tbody>

<?php if(!empty($ranking)): ?>

<?php $pos = 1; foreach($ranking as $r): ?>

<tr>
<td><strong><?= $pos++ ?>º</strong></td>

<td>
    <?= htmlspecialchars($r['profissional'] ?? '---') ?>
</td>

<td class="text-primary">
    R$ <?= number_format((float)($r['producao'] ?? 0),2,',','.') ?>
</td>

<td class="text-success">
    R$ <?= number_format((float)($r['comissao'] ?? 0),2,',','.') ?>
</td>
</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
<td colspan="4" class="text-center text-muted">
Nenhum dado encontrado
</td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>
</div>

</div>