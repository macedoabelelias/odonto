<!-- DOCUMENTOS -->

<div class="col-md-3">
<div class="card shadow-sm card-compacto h-100">

<div class="card-body p-2">

<h6>📂 Documentos</h6>

<form method="POST"
action="<?= BASE_URL ?>/documentos/upload"
enctype="multipart/form-data">

<input type="hidden"
name="paciente_id"
value="<?= $paciente['id'] ?>">

<input type="file"
name="arquivo"
class="form-control mb-2">

<button class="btn btn-primary btn-sm w-100">

Enviar documento

</button>

</form>

</div>
</div>
</div>