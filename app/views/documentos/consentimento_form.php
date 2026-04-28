<h4>Termo de Consentimento</h4>

<div class="alert alert-info">

Paciente: <strong><?= $paciente['nome'] ?></strong>

</div>

<form method="POST" action="<?= BASE_URL ?>/documentos/consentimento/<?= $paciente['id'] ?>">

<div class="mb-3">

<label class="form-label">Procedimento</label>

<input
type="text"
name="procedimento"
class="form-control"
placeholder="Ex: Exodontia de terceiro molar"
required>

</div>

<div class="mb-3">

<label class="form-label">Observações</label>

<textarea
name="observacoes"
class="form-control"
rows="3"></textarea>

</div>

<button class="btn btn-success">

Gerar Consentimento

</button>

</form>