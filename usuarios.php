<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin(); // apenas admin pode acessar

$sql = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';
?>

<h3 class="mb-4">Usuários do Sistema</h3>

<div class="card shadow-sm">
<div class="card-body">

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalUsuario">
Novo Usuário
</button>

<table class="table table-striped">
<thead>
<tr>
<th>Nome</th>
<th>Email</th>
<th>Nível</th>
<th>Ações</th>
</tr>
</thead>
<tbody>

<?php foreach($usuarios as $u): ?>
<tr>
<td><?= htmlspecialchars($u['nome']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= strtoupper($u['nivel']) ?></td>
<td>

<button class="btn btn-warning btn-sm btn-editar"
data-id="<?= $u['id'] ?>"
data-nome="<?= htmlspecialchars($u['nome']) ?>"
data-email="<?= htmlspecialchars($u['email']) ?>"
data-nivel="<?= $u['nivel'] ?>">
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

<!-- MODAL -->
<div class="modal fade" id="modalUsuario">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
<h5 class="modal-title">Cadastrar Usuário</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form method="POST" action="usuario_salvar.php">

<input type="hidden" name="id" id="usuario_id">

<div class="modal-body">

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

<script>
document.querySelectorAll('.btn-editar').forEach(btn => {
btn.addEventListener('click', function(){

document.getElementById('usuario_id').value = this.dataset.id;
document.getElementById('nome').value = this.dataset.nome;
document.getElementById('email').value = this.dataset.email;
document.getElementById('nivel').value = this.dataset.nivel;
document.getElementById('senha').value = '';

});
});
</script>

<?php include 'layout/footer.php'; ?>