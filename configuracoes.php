<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

somenteAdmin();

$config = $pdo->query("SELECT * FROM configuracoes LIMIT 1")->fetch(PDO::FETCH_ASSOC);

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';
?>

<h3 class="mb-4">Configurações do Sistema</h3>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" action="configuracoes_salvar.php" enctype="multipart/form-data">

<div class="mb-3">
<label>Nome da Clínica</label>
<input type="text" name="nome_clinica" class="form-control"
value="<?= htmlspecialchars($config['nome_clinica']) ?>">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control"
value="<?= htmlspecialchars($config['email']) ?>">
</div>

<div class="mb-3">
<label>Telefone</label>
<input type="text" name="telefone" class="form-control"
value="<?= htmlspecialchars($config['telefone']) ?>">
</div>

<div class="mb-3">
<label>Logomarca</label>
<input type="file" name="logo" class="form-control">

<?php if($config['logo']): ?>
<br>
<img src="/odonto/uploads/<?= $config['logo'] ?>" width="150">
<?php endif; ?>
</div>

<button class="btn btn-primary">Salvar Configurações</button>

</form>



</div>
</div>

<?php include 'layout/footer.php'; ?>