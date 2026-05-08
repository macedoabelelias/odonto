<h4 class="mb-4">Fila de Atendimento</h4>

<table class="table table-bordered">

<tr>
<th>Paciente</th>
<th>Chegada</th>
<th>Ação</th>
</tr>

<?php foreach($fila as $f): ?>

<tr>

<td><?= htmlspecialchars($f['paciente']) ?></td>

<td><?= date("H:i",strtotime($f['hora_chegada'])) ?></td>

<td>

<a href="<?= BASE_URL ?>/fila/chamar/<?= $f['id'] ?>" 
class="btn btn-success btn-sm">

Chamar

</a>

<a href="<?= BASE_URL ?>/fila/finalizar/<?= $f['id'] ?>" 
class="btn btn-danger btn-sm">

Finalizar

</a>

</td>

</tr>

<?php endforeach; ?>

</table>