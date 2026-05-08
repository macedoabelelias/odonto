<h4 class="mb-4">Editar Consulta</h4>

<form method="POST" action="<?= BASE_URL ?>/consultas/atualizar/<?= $consulta['id'] ?>">

<div class="mb-3">
<label>Paciente</label>

<select name="paciente_id" class="form-control">

<?php foreach($pacientes as $p): ?>

<option value="<?= $p['id'] ?>"
<?= $p['id']==$consulta['paciente_id']?'selected':'' ?>>

<?= $p['nome'] ?>

</option>

<?php endforeach; ?>

</select>

</div>



<div class="mb-3">
<label>Dentista</label>

<select name="usuario_id" class="form-control">

<?php foreach($dentistas as $d): ?>

<option value="<?= $d['id'] ?>"
<?= $d['id']==$consulta['usuario_id']?'selected':'' ?>>

<?= $d['nome'] ?>

</option>

<?php endforeach; ?>

</select>

</div>



<div class="mb-3">

<label>Data</label>

<input type="date"
name="data"
class="form-control"
value="<?= $consulta['data'] ?>">

</div>


<div class="mb-3">

<label>Hora</label>

<input type="time"
name="hora"
class="form-control"
value="<?= $consulta['hora'] ?>">

</div>


<div class="mb-3">

<label>Procedimento</label>

<input type="text"
name="procedimento"
class="form-control"
value="<?= $consulta['procedimento'] ?>">

</div>


<div class="mb-3">

<label>Status</label>

<select name="status" class="form-control">

<option value="agendado"
<?= $consulta['status']=='agendado'?'selected':'' ?>>
Agendado
</option>

<option value="atendimento"
<?= $consulta['status']=='atendimento'?'selected':'' ?>>
Em atendimento
</option>

<option value="finalizado"
<?= $consulta['status']=='finalizado'?'selected':'' ?>>
Finalizado
</option>

<option value="faltou"
<?= $consulta['status']=='faltou'?'selected':'' ?>>
Faltou
</option>

</select>

</div>


<div class="mb-3">

<label>Observações</label>

<textarea name="observacoes" class="form-control">

<?= $consulta['observacoes'] ?>

</textarea>

</div>


<button class="btn btn-primary">

Salvar Alterações

</button>

</form>