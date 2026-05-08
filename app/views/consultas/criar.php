<div class="container-fluid">

<div class="card shadow-sm border-0">

<div class="card-header bg-white">

<h4 class="mb-0">
<i class="bi bi-calendar-plus"></i>
Nova Consulta
</h4>

</div>


<div class="card-body">


<?php if(!empty($_SESSION['erro'])): ?>

<div class="alert alert-danger">

<?= $_SESSION['erro'] ?>

</div>

<?php unset($_SESSION['erro']); ?>

<?php endif; ?>


<form method="POST" action="<?= BASE_URL ?>/consultas/salvar">

<div class="row">

<!-- PACIENTE -->
<div class="col-md-6 mb-3">

<label class="form-label">Paciente</label>

<select name="paciente_id" class="form-control">

<?php foreach($pacientes as $p): ?>

<option value="<?= $p['id'] ?>"
<?= ($pacienteSelecionado == $p['id']) ? 'selected' : '' ?>>

<?= htmlspecialchars($p['nome']) ?>

</option>

<?php endforeach; ?>

</select>

</div>


<!-- DENTISTA -->
<div class="col-md-6 mb-3">

<label class="form-label">Dentista</label>

<select name="usuario_id" class="form-select">

<?php foreach($dentistas as $d): ?>

<option value="<?= $d['id'] ?>">
<?= htmlspecialchars($d['nome']) ?>
</option>

<?php endforeach; ?>

</select>

</div>


<!-- DATA -->
<div class="col-md-3 mb-3">

<label class="form-label">Data</label>

<input type="date"
name="data"
class="form-control"
value="<?= $data ?? '' ?>">

</div>


<!-- HORA -->
<div class="col-md-3 mb-3">

<label class="form-label">Hora</label>

<input type="time"
name="hora"
class="form-control"
value="<?= $hora ?? '' ?>">

</div>

<div class="mb-3">
<label>Duração</label>

<select name="duracao" class="form-control">

<option value="30">30 minutos</option>
<option value="45">45 minutos</option>
<option value="60">1 hora</option>
<option value="90">1h30</option>
<option value="120">2 horas</option>

</select>
</div>


<!-- PROCEDIMENTO -->
<div class="col-md-6 mb-3">

<label class="form-label">Procedimento</label>

<input type="text" name="procedimento" class="form-control">

</div>


<!-- OBSERVAÇÕES -->
<div class="col-md-12 mb-4">

<label class="form-label">Observações</label>

<textarea name="observacoes" rows="3" class="form-control"></textarea>

</div>


</div>


<div class="d-flex justify-content-between">

<a href="<?= BASE_URL ?>/consultas" class="btn btn-outline-secondary">
Cancelar
</a>

<button class="btn btn-primary px-4">
Salvar Consulta
</button>

</div>

</form>

</div>

</div>

</div>