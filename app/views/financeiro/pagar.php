<h4 class="mb-4">💸 Contas a Pagar</h4>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-sm">

<thead>
<tr>
<th>Descrição</th>
<th>Valor</th>
<th>Vencimento</th>
<th>Status</th>
<th>Ação</th>
</tr>
</thead>

<tbody>

<?php foreach($contas as $c): ?>

<tr>

<td><?= $c['descricao'] ?></td>
<td>R$ <?= number_format($c['valor'],2,',','.') ?></td>
<td><?= date('d/m/Y', strtotime($c['data_vencimento'])) ?></td>

<td>
<?php if($c['status']=='pendente'): ?>
<span class="badge bg-warning">Pendente</span>
<?php else: ?>
<span class="badge bg-success">Pago</span>
<?php endif; ?>
</td>

<td>
<?php if($c['status']=='pendente'): ?>
<button class="btn btn-danger btn-sm btn-pagar" data-id="<?= $c['id'] ?>">
💸 Pagar
</button>
<?php endif; ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>
</div>