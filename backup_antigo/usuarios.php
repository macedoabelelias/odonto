<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin();

$sql = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';
?>

<h3 class="mb-4">Usuários do Sistema</h3>

<div class="card shadow-sm">
<div class="card-body">

<button class="btn btn-primary mb-3" id="btnNovo" data-bs-toggle="modal" data-bs-target="#modalUsuario">
Novo Usuário
</button>

<table class="table table-striped">
<thead>
<tr>
<th>Foto</th>
<th>Nome</th>
<th>Email</th>
<th>Nível</th>
<th>Ações</th>
</tr>
</thead>
<tbody>

<?php foreach($usuarios as $u): ?>
<tr>

<td>
<?php if(!empty($u['foto']) && file_exists("uploads/".$u['foto'])): ?>
<img src="/odonto/uploads/<?= $u['foto'] ?>" 
     width="40" height="40"
     class="rounded-circle">
<?php else: ?>
-
<?php endif; ?>
</td>

<td><?= htmlspecialchars($u['nome']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= strtoupper($u['nivel']) ?></td>

<td>

<button type="button"
class="btn btn-warning btn-sm btn-editar"
data-id="<?= $u['id'] ?>"
data-nome="<?= htmlspecialchars($u['nome']) ?>"
data-email="<?= htmlspecialchars($u['email']) ?>"
data-nivel="<?= $u['nivel'] ?>"
data-foto="<?= $u['foto'] ?>">
Editar
</button>

<a href="usuario_excluir.php?id=<?= $u['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Excluir usuário?')">
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

<div class="modal fade" id="modalUsuario">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
<h5 class="modal-title" id="tituloModal">Cadastrar Usuário</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form method="POST" action="usuario_salvar.php" enctype="multipart/form-data">

<input type="hidden" name="id" id="usuario_id">

<div class="modal-body">

<div class="mb-3 text-center">
<label>Foto do Usuário</label>

<div class="mb-2">
<img id="previewUsuario"
src="https://via.placeholder.com/100x100?text=Foto"
width="100"
class="rounded-circle border">
</div>

<input type="file" name="foto" id="fotoUsuario" class="form-control">
</div>

<div class="mb-3">
<label>Nome</label>
<input type="text" name="nome" id="nome" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" id="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Senha</label>
<input type="password" name="senha" id="senha" class="form-control">
<small class="text-muted">Deixe em branco para não alterar (na edição).</small>
</div>

<div class="mb-3">
<label>Nível de Acesso</label>
<select name="nivel" id="nivel" class="form-select">
<option value="admin">Administrador</option>
<option value="recepcao">Recepção</option>
<option value="auxiliar">Auxiliar</option>
<option value="dentista">Dentista</option>
</select>
</div>

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary">Salvar</button>
</div>

</form>

</div>
</div>
</div>

<!-- ================= JS MODERNO ================= -->

<script>
document.addEventListener("DOMContentLoaded", function(){

const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
const preview = document.getElementById('previewUsuario');
const inputFoto = document.getElementById('fotoUsuario');
const btnNovo = document.getElementById('btnNovo');

document.querySelectorAll('.btn-editar').forEach(btn => {

btn.addEventListener('click', function(){

document.getElementById('tituloModal').innerText = "Editar Usuário";

document.getElementById('usuario_id').value = this.dataset.id;
document.getElementById('nome').value = this.dataset.nome;
document.getElementById('email').value = this.dataset.email;
document.getElementById('nivel').value = this.dataset.nivel;
document.getElementById('senha').value = '';

if(this.dataset.foto){
preview.src = "/odonto/uploads/" + this.dataset.foto;
}else{
preview.src = "https://via.placeholder.com/100x100?text=Foto";
}

modal.show();

});

});

btnNovo.addEventListener('click', function(){

document.getElementById('tituloModal').innerText = "Cadastrar Usuário";
document.getElementById('usuario_id').value = '';
document.querySelector('#modalUsuario form').reset();
preview.src = "https://via.placeholder.com/100x100?text=Foto";

});

inputFoto.addEventListener('change', function(){

if(this.files && this.files[0]){
let reader = new FileReader();

reader.onload = function(e){
preview.src = e.target.result;
}

reader.readAsDataURL(this.files[0]);
}

});

});
</script>

<?php include 'layout/footer.php'; ?>