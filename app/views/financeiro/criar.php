

<h4 class="mb-4">💰 Nova Conta</h4>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" action="<?= BASE_URL ?>/contasReceber/salvar">

<div class="mb-3">
<label>Paciente</label>

<select name="paciente_id" class="form-control" required>

<option value="">Selecione</option>

<?php foreach($pacientes as $p): ?>

<option value="<?= $p['id'] ?>">
<?= htmlspecialchars($p['nome']) ?>
</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">
<label>Descrição</label>
<input type="text" name="descricao" class="form-control">
</div>

<div class="mb-3">
<label>Valor</label>
<input type="text" name="valor" class="form-control" required>
</div>

<div class="mb-3">
<label>Data de Vencimento</label>
<input type="date" name="data_vencimento" class="form-control" required>
</div>

<button class="btn btn-success w-100">
Salvar Conta
</button>

</form>

</div>
</div>