<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

$id = $_SESSION['usuario_id'];

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$sql->execute([':id'=>$id]);
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';
?>

<h3 class="mb-4">Meu Perfil</h3>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" action="usuario_salvar.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $usuario['id'] ?>">

<div class="row">

<div class="col-md-3 text-center mb-3">
    <img src="<?= !empty($usuario['foto']) ? '/odonto/uploads/'.$usuario['foto'] : 'https://via.placeholder.com/150' ?>"
         class="rounded-circle border"
         width="150" height="150">

    <input type="file" name="foto" class="form-control mt-2">
</div>

<div class="col-md-9">

<div class="row">
<div class="col-md-6 mb-3">
<label>Nome</label>
<input type="text" name="nome" class="form-control"
value="<?= htmlspecialchars($usuario['nome']) ?>">
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control"
value="<?= htmlspecialchars($usuario['email']) ?>">
</div>

<div class="col-md-6 mb-3">
<label>CPF</label>
<input type="text" name="cpf" class="form-control"
value="<?= htmlspecialchars($usuario['cpf'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Telefone</label>
<input type="text" name="telefone" class="form-control"
value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Data de Nascimento</label>
<input type="date" name="data_nascimento" class="form-control"
value="<?= htmlspecialchars($usuario['data_nascimento'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>CEP</label>
<input type="text" name="cep" id="cep" class="form-control"
value="<?= htmlspecialchars($usuario['cep'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Endereço</label>
<input type="text" name="endereco" id="endereco" class="form-control"
value="<?= htmlspecialchars($usuario['endereco'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Bairro</label>
<input type="text" name="bairro" id="bairro" class="form-control"
value="<?= htmlspecialchars($usuario['bairro'] ?? '') ?>">
</div>

<div class="col-md-3 mb-3">
<label>Número</label>
<input type="text" name="numero" class="form-control"
value="<?= htmlspecialchars($usuario['numero'] ?? '') ?>">
</div>

<div class="col-md-3 mb-3">
<label>UF</label>
<input type="text" name="uf" id="uf" class="form-control"
value="<?= htmlspecialchars($usuario['uf'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Cidade</label>
<input type="text" name="cidade" id="cidade" class="form-control"
value="<?= htmlspecialchars($usuario['cidade'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Registro no Conselho</label>
<input type="text" name="registro_conselho" class="form-control"
value="<?= htmlspecialchars($usuario['registro_conselho'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Especialidade</label>
<input type="text" name="especialidade" class="form-control"
value="<?= htmlspecialchars($usuario['especialidade'] ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Nova Senha</label>
<input type="password" name="senha" class="form-control">
</div>

</div>

<button class="btn btn-primary">Salvar Alterações</button>

</div>
</div>

</form>

</div>
</div>

<script>
document.getElementById('cep').addEventListener('blur', function(){

let cep = this.value.replace(/\D/g,'');

if(cep.length == 8){

fetch("https://viacep.com.br/ws/"+cep+"/json/")
.then(res => res.json())
.then(data => {

if(!data.erro){
document.getElementById('endereco').value = data.logradouro;
document.getElementById('bairro').value = data.bairro;
document.getElementById('cidade').value = data.localidade;
document.getElementById('uf').value = data.uf;
}

});

}

});
</script>

<script>

// ===== CPF =====
document.querySelector("input[name='cpf']").addEventListener("input", function(){

let v = this.value.replace(/\D/g,'');

v = v.replace(/(\d{3})(\d)/,"$1.$2");
v = v.replace(/(\d{3})(\d)/,"$1.$2");
v = v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");

this.value = v;

});

// ===== TELEFONE =====
document.querySelector("input[name='telefone']").addEventListener("input", function(){

let v = this.value.replace(/\D/g,'');

if(v.length <= 10){
v = v.replace(/(\d{2})(\d)/,"($1) $2");
v = v.replace(/(\d{4})(\d)/,"$1-$2");
}else{
v = v.replace(/(\d{2})(\d)/,"($1) $2");
v = v.replace(/(\d{5})(\d)/,"$1-$2");
}

this.value = v;

});

// ===== CEP =====
document.querySelector("input[name='cep']").addEventListener("input", function(){

let v = this.value.replace(/\D/g,'');
v = v.replace(/(\d{5})(\d)/,"$1-$2");

this.value = v;

});

</script>

<?php include 'layout/footer.php'; ?>