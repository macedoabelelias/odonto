<h4 class="mb-4">Configurações do Sistema</h4>

<form method="POST" action="<?= BASE_URL ?>/configuracoes/salvar" enctype="multipart/form-data">

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">🏥 Dados da Clínica</h6>

<label>Nome da Clínica</label>
<input type="text"
name="nome_clinica"
value="<?= $config['nome_clinica'] ?? '' ?>"
class="form-control mb-3">

</div>
</div>


<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">🖼 Logo do Sistema</h6>

<?php if(!empty($config['logo'])): ?>

<div class="mb-3">
<img src="<?= BASE_URL ?>/assets/img/<?= $config['logo'] ?>" width="120" style="border-radius:10px">
</div>

<?php endif; ?>

<input type="file" name="logo" class="form-control">

</div>
</div>


<button class="btn btn-success">
Salvar Configurações
</button>

</form>