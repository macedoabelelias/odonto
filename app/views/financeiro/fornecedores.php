<h4>🏢 Fornecedores</h4>

<a href="<?= BASE_URL ?>/fornecedores/criar" class="btn btn-primary btn-sm mb-3">
+ Novo Fornecedor
</a>

<table class="table table-sm">

<tr>
<th>Nome</th>
<th>CNPJ</th>
<th>Telefone</th>
<th>Cidade</th>
<th>Ação</th>
</tr>

<?php foreach($fornecedores as $f): ?>

<tr>
<td><?= $f['nome'] ?></td>
<td><?= $f['cnpj'] ?></td>
<td><?= $f['telefone'] ?></td>
<td><?= $f['cidade'] ?></td>

<td>
<a href="<?= BASE_URL ?>/fornecedores/excluir/<?= $f['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Excluir?')">🗑</a>
</td>

</tr>

<?php endforeach; ?>

</table>
