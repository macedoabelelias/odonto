<h4>Usuários</h4>

<a href="<?= BASE_URL ?>/usuarios/criar" class="btn btn-success mb-3">
Novo Usuário
</a>

<table class="table">

<tr>
<th>Foto</th>
<th>Nome</th>
<th>Email</th>
<th>Nível</th>
<th>Ações</th>
</tr>

<?php foreach($usuarios as $usuario): ?>

<tr>

<td>

<?php if(!empty($usuario['foto'])): ?>

<img src="<?= BASE_URL ?>/assets/img/usuarios/<?= $usuario['foto'] ?>" width="60">

<?php else: ?>

<img src="<?= BASE_URL ?>/assets/img/user.png" width="60">

<?php endif; ?>

</td>

<td><?= $usuario['nome'] ?></td>
<td><?= $usuario['email'] ?></td>
<td><?= $usuario['nivel'] ?></td>

<td>
<a href="<?= BASE_URL ?>/usuarios/editar/<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
<a href="<?= BASE_URL ?>/usuarios/excluir/<?= $usuario['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
</td>

</tr>

<?php endforeach ?>

</table>