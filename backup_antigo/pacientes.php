<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';

$sql = $pdo->query("SELECT * FROM pacientes ORDER BY id DESC");
$pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);


?>

<h3 class="mb-4">Pacientes</h3>

<div class="card shadow-sm">
<div class="card-body">

<div class="d-flex justify-content-end mb-3">
<button class="btn btn-primary" id="btnNovo" data-bs-toggle="modal" data-bs-target="#modalPaciente">
Novo Paciente
</button>
</div>

<table class="table table-striped">
<thead>
<tr>
<th>Foto</th>
<th>Nome</th>
<th>Telefone</th>
<th>Idade</th>
<th>Ações</th>
</tr>
</thead>
<tbody>

<?php foreach($pacientes as $p): ?>
<tr>

<td>
<?php if(!empty($p['foto']) && file_exists("uploads/".$p['foto'])): ?>
<img src="uploads/<?= $p['foto'] ?>" width="50" height="50" class="rounded-circle">
<?php else: ?>
-
<?php endif; ?>
</td>

<td><?= htmlspecialchars($p['nome']) ?></td>
<td><?= htmlspecialchars($p['telefone']) ?></td>
<td>
<?php
if(!empty($p['data_nascimento'])){
echo (new DateTime($p['data_nascimento']))->diff(new DateTime())->y . " anos";
}
?>
</td>

<td>

<button type="button"
class="btn btn-warning btn-sm btn-editar"
data-id="<?= $p['id'] ?>"
data-foto="<?= htmlspecialchars($p['foto'] ?? '') ?>"
data-nome="<?= htmlspecialchars($p['nome'] ?? '') ?>"
data-cpf="<?= htmlspecialchars($p['cpf'] ?? '') ?>"
data-data="<?= $p['data_nascimento'] ?? '' ?>"
data-telefone="<?= htmlspecialchars($p['telefone'] ?? '') ?>"
data-email="<?= htmlspecialchars($p['email'] ?? '') ?>"
data-cep="<?= htmlspecialchars($p['cep'] ?? '') ?>"
data-endereco="<?= htmlspecialchars($p['endereco'] ?? '') ?>"
data-bairro="<?= htmlspecialchars($p['bairro'] ?? '') ?>"
data-cidade="<?= htmlspecialchars($p['cidade'] ?? '') ?>"
data-estado="<?= htmlspecialchars($p['estado'] ?? '') ?>"
data-convenio="<?= htmlspecialchars($p['convenio'] ?? '') ?>"
data-instagram="<?= htmlspecialchars($p['instagram'] ?? '') ?>"
data-whatsapp="<?= htmlspecialchars($p['whatsapp'] ?? '') ?>"
data-tipo_sanguineo="<?= htmlspecialchars($p['tipo_sanguineo'] ?? '') ?>"
data-estado_civil="<?= htmlspecialchars($p['estado_civil'] ?? '') ?>"
data-genero="<?= htmlspecialchars($p['genero'] ?? '') ?>"
data-profissao="<?= htmlspecialchars($p['profissao'] ?? '') ?>"
data-responsavel_nome="<?= htmlspecialchars($p['responsavel_nome'] ?? '') ?>"
data-responsavel_telefone="<?= htmlspecialchars($p['responsavel_telefone'] ?? '') ?>"
data-responsavel_email="<?= htmlspecialchars($p['responsavel_email'] ?? '') ?>"
data-responsavel_cpf="<?= htmlspecialchars($p['responsavel_cpf'] ?? '') ?>"
data-observacoes="<?= htmlspecialchars($p['observacoes'] ?? '') ?>">
Editar
</button>

<a href="prontuario.php?id=<?= $p['id'] ?>" class="btn btn-info btn-sm">
Prontuário
</a>

<a href="paciente_excluir.php?id=<?= $p['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Excluir paciente?')">
Excluir
</a>

</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

</div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="modalPaciente" tabindex="-1">
<div class="modal-dialog modal-xl">
<div class="main-content">
    <div class="content-card">

<div class="modal-header bg-primary text-white">
<h5 class="modal-title" id="tituloModal">Cadastrar Paciente</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form method="POST" action="paciente_salvar.php" enctype="multipart/form-data">

<input type="hidden" name="id" id="paciente_id">

<div class="modal-body">
<div class="row g-3">

<div class="col-md-3 text-center">
<label>Foto</label>
<div class="mb-2">
<img id="previewFoto"
src="https://via.placeholder.com/120x120?text=Sem+Foto"
width="120"
class="rounded-circle border">
</div>
<input type="file" name="foto" id="inputFoto" class="form-control">
</div>

<div class="col-md-9">
<label>Nome Completo</label>
<input type="text" name="nome" class="form-control" required>
</div>

<div class="col-md-4">
<label>Telefone</label>
<input type="text" name="telefone" id="telefone" class="form-control">
</div>

<div class="col-md-4">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="col-md-4">
<label>CPF</label>
<input type="text" name="cpf" id="cpf" class="form-control">
</div>

<div class="col-md-3">
<label>Data Nascimento</label>
<input type="date" name="data_nascimento" id="data_nascimento" class="form-control">
</div>

<div class="col-md-2">
<label>Idade</label>
<input type="text" id="idade" class="form-control" readonly>
</div>

<div class="col-md-3">
<label>Tipo Sanguíneo</label>
<select name="tipo_sanguineo" class="form-select">
<option value="">Selecione</option>
<option>A+</option><option>A-</option>
<option>B+</option><option>B-</option>
<option>AB+</option><option>AB-</option>
<option>O+</option><option>O-</option>
</select>
</div>

<div class="col-md-4">
<label>Estado Civil</label>
<select name="estado_civil" class="form-select">
<option>Solteiro(a)</option>
<option>Casado(a)</option>
<option>Divorciado(a)</option>
<option>Viúvo(a)</option>
<option>Outros</option>
</select>
</div>

<div class="col-md-4">
<label>Gênero</label>
<select name="genero" class="form-select">
<option>Cis Masculino</option>
<option>Cis Feminino</option>
<option>Trans Masculino</option>
<option>Trans Feminino</option>
<option>Outros</option>
</select>
</div>

<div class="col-md-4">
<label>Profissão</label>
<input type="text" name="profissao" class="form-control">
</div>

<h6 class="fw-bold mt-4">Endereço</h6>
<hr>

<div class="col-md-3">
<label>CEP</label>
<input type="text" name="cep" id="cep" class="form-control">
</div>

<div class="col-md-9">
<label>Endereço</label>
<input type="text" name="endereco" id="endereco" class="form-control">
</div>

<div class="col-md-4">
<label>Bairro</label>
<input type="text" name="bairro" id="bairro" class="form-control">
</div>

<div class="col-md-4">
<label>Cidade</label>
<input type="text" name="cidade" id="cidade" class="form-control">
</div>

<div class="col-md-4">
<label>Estado</label>
<input type="text" name="estado" id="estado" class="form-control">
</div>

<h6 class="fw-bold mt-4">Dados Sociais</h6>
<hr>

<div class="col-md-4">
<label>Convênio</label>
<input type="text" name="convenio" class="form-control">
</div>

<div class="col-md-4">
<label>Instagram</label>
<input type="text" name="instagram" class="form-control">
</div>

<div class="col-md-4">
<label>WhatsApp</label>
<input type="text" name="whatsapp" id="whatsapp" class="form-control">
</div>

<h6 class="fw-bold mt-4">Responsável (Menor)</h6>
<hr>

<div class="col-md-6">
<label>Nome</label>
<input type="text" name="responsavel_nome" class="form-control">
</div>

<div class="col-md-3">
<label>Telefone</label>
<input type="text" name="responsavel_telefone" id="resp_tel" class="form-control">
</div>

<div class="col-md-3">
<label>CPF</label>
<input type="text" name="responsavel_cpf" id="resp_cpf" class="form-control">
</div>

<div class="col-md-6">
<label>Email</label>
<input type="email" name="responsavel_email" class="form-control">
</div>

<h6 class="fw-bold mt-4">Observações</h6>
<hr>

<div class="col-md-12">
<textarea name="observacoes" class="form-control"></textarea>
</div>

</div>
</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary">Salvar</button>
</div>

</form>
</div>
</div>
</div>
</div>

<!-- ================= JS MODERNO ================= -->
<script>

document.addEventListener("DOMContentLoaded", function(){

const modal = new bootstrap.Modal(document.getElementById('modalPaciente'));
const previewFoto = document.getElementById('previewFoto');
const inputFoto = document.getElementById('inputFoto');
const btnNovo = document.getElementById('btnNovo');

document.querySelectorAll('.btn-editar').forEach(btn => {

btn.addEventListener('click', function(){

document.getElementById('tituloModal').innerText = "Editar Paciente";
document.getElementById('paciente_id').value = this.dataset.id || '';

document.querySelector('[name="nome"]').value = this.dataset.nome || '';
document.getElementById('cpf').value = this.dataset.cpf || '';
document.getElementById('data_nascimento').value = this.dataset.data || '';
document.getElementById('telefone').value = this.dataset.telefone || '';
document.querySelector('[name="email"]').value = this.dataset.email || '';

document.getElementById('cep').value = this.dataset.cep || '';
document.getElementById('endereco').value = this.dataset.endereco || '';
document.getElementById('bairro').value = this.dataset.bairro || '';
document.getElementById('cidade').value = this.dataset.cidade || '';
document.getElementById('estado').value = this.dataset.estado || '';

document.querySelector('[name="convenio"]').value = this.dataset.convenio || '';
document.querySelector('[name="instagram"]').value = this.dataset.instagram || '';
document.getElementById('whatsapp').value = this.dataset.whatsapp || '';

document.querySelector('[name="tipo_sanguineo"]').value = this.dataset.tipo_sanguineo || '';
document.querySelector('[name="estado_civil"]').value = this.dataset.estado_civil || '';
document.querySelector('[name="genero"]').value = this.dataset.genero || '';
document.querySelector('[name="profissao"]').value = this.dataset.profissao || '';

document.querySelector('[name="responsavel_nome"]').value = this.dataset.responsavel_nome || '';
document.getElementById('resp_tel').value = this.dataset.responsavel_telefone || '';
document.getElementById('resp_cpf').value = this.dataset.responsavel_cpf || '';
document.querySelector('[name="responsavel_email"]').value = this.dataset.responsavel_email || '';

document.querySelector('[name="observacoes"]').value = this.dataset.observacoes || '';

if(this.dataset.foto){
previewFoto.src = "uploads/" + this.dataset.foto;
}else{
previewFoto.src = "https://via.placeholder.com/120x120?text=Sem+Foto";
}

if(this.dataset.data){
let nascimento = new Date(this.dataset.data);
let hoje = new Date();
let idade = hoje.getFullYear() - nascimento.getFullYear();
document.getElementById('idade').value = idade + " anos";
}

modal.show();

});

});

btnNovo.addEventListener('click', function(){
document.getElementById('tituloModal').innerText = "Cadastrar Paciente";
document.querySelector('#modalPaciente form').reset();
document.getElementById('paciente_id').value = '';
previewFoto.src = "https://via.placeholder.com/120x120?text=Sem+Foto";
});

inputFoto.addEventListener('change', function(){
if(this.files && this.files[0]){
let reader = new FileReader();
reader.onload = function(e){
previewFoto.src = e.target.result;
}
reader.readAsDataURL(this.files[0]);
}
});

});
</script>

<?php include 'layout/footer.php'; ?>