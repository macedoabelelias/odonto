<h4>Usuários</h4>

<a href="<?= BASE_URL ?>/usuarios/criar" class="btn btn-success mb-3">
    Novo Usuário
</a>

<div style="overflow-x:auto;">
   
<table class="table" style="width:100%; border-collapse: collapse;">

<thead>
<tr style="background:#f5f5f5;">
    <th>Foto</th>
    <th>Nome</th>
    <th>Email</th>
    <th>Nível</th>
    <th>Ações</th>
</tr>
</thead>

<tbody>

<?php foreach($usuarios as $usuario): ?>

<tr style="border-bottom:1px solid #ddd;">

<td>
    <?php if(!empty($usuario['foto'])): ?>
        <img src="<?= BASE_URL ?>/assets/img/usuarios/<?= $usuario['foto'] ?>" width="50" height="50" style="border-radius:50%; object-fit:cover;">
    <?php else: ?>
        <img src="<?= BASE_URL ?>/assets/img/user.png" width="50" height="50" style="border-radius:50%;">
    <?php endif; ?>
</td>

<td><?= $usuario['nome'] ?></td>
<td><?= $usuario['email'] ?></td>

<!-- NÍVEL COM CORES -->
<td>
<?php 
$nivelNome = $usuario['nivel_nome'] ?? null;

if(!empty($nivelNome)):

    $nivel = strtolower(trim($nivelNome));
    $cor = '#6c757d'; // padrão (cinza)

    switch($nivel){
        case 'administrador': $cor = '#dc3545'; break;
        case 'dentista': $cor = '#28a745'; break;
        case 'recepcao': $cor = '#17a2b8'; break;
        case 'financeiro': $cor = '#ffc107'; break;
    }
?>

    <span style="
        background:<?= $cor ?>;
        color:#fff;
        padding:5px 10px;
        border-radius:6px;
        font-size:13px;
        display:inline-block;
    ">
        <?= ucfirst($nivelNome) ?>
    </span>

<?php else: ?>

    <span style="
        background:#e9ecef;
        color:#6c757d;
        padding:5px 10px;
        border-radius:6px;
        font-size:13px;
    ">
        Sem nível
    </span>

<?php endif; ?>
</td>

<td>
    <a href="<?= BASE_URL ?>/usuarios/editar/<?= $usuario['id'] ?>" 
       class="btn btn-warning btn-sm">
       Editar
    </a>

    <a href="<?= BASE_URL ?>/usuarios/excluir/<?= $usuario['id'] ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('Deseja excluir este usuário?')">
       Excluir
    </a>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>