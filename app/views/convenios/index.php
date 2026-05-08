<h4>📋 Convênios</h4>

<a href="<?= BASE_URL ?>/convenios/novo" class="btn btn-primary mb-3">
    + Novo Convênio
</a>

<table class="table table-bordered">

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>% Comissão</th>
    <th>Ações</th>
</tr>

<?php foreach($convenios as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['nome'] ?></td>
    <td><?= $c['percentual'] ?>%</td>
    <td>
        <a href="<?= BASE_URL ?>/convenios/editar/<?= $c['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= BASE_URL ?>/convenios/excluir/<?= $c['id'] ?>" class="btn btn-sm btn-danger"
           onclick="return confirm('Excluir convênio?')">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>

</table>