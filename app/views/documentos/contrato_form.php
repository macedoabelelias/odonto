<h4 class="mb-3">📄 Contrato</h4>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" action="<?= BASE_URL ?>/documentos/gerar_contrato">

<input type="hidden" name="paciente_id" value="<?= $paciente['id'] ?>">

<div class="mb-3">
<label class="form-label">Tratamento</label>
<textarea name="tratamento" class="form-control" rows="3" required></textarea>
</div>

<div class="mb-3">
<label class="form-label">Valor</label>
<input type="text" name="valor" class="form-control" required>
</div>

<button class="btn btn-success w-100">
Gerar Contrato
</button>

</form>

</div>
</div>