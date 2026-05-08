<h4 class="mb-4">Meu Perfil</h4>

<form method="POST" action="<?= BASE_URL ?>/usuarios/atualizarPerfil" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $usuario['id'] ?>">

<div class="row">

<div class="col-md-6">

<label>Nome</label>
<input type="text" name="nome" class="form-control mb-2" value="<?= $usuario['nome'] ?>">

<label>Email</label>
<input type="email" name="email" class="form-control mb-2" value="<?= $usuario['email'] ?>">

<label>Telefone</label>
<input type="text" name="telefone" id="telefone"
class="form-control mb-2"
value="<?= $usuario['telefone'] ?>"
placeholder="(00) 00000-0000">

<label>CPF / CNPJ</label>

<input type="text"
name="cpf_cnpj"
id="cpf_cnpj"
class="form-control mb-2"
value="<?= $usuario['cpf_cnpj'] ?? '' ?>"
placeholder="CPF ou CNPJ">

<label>Especialidade</label>
<input type="text" name="especialidade" class="form-control mb-2" value="<?= $usuario['especialidade'] ?>">

<label>Registro Conselho</label>
<input type="text" name="registro_conselho" class="form-control mb-2" value="<?= $usuario['registro_conselho'] ?>">

</div>


<div class="col-md-6">

<label>Foto</label>

<?php if(!empty($usuario['foto'])): ?>

<div class="mb-2">
<img src="<?= BASE_URL ?>/assets/img/usuarios/<?= $usuario['foto'] ?>" width="80">
</div>

<?php endif; ?>

<input type="file" name="foto" class="form-control mb-3">

<hr>

<h6>Alterar senha</h6>

<label>Nova senha</label>
<input type="password" name="nova_senha" class="form-control mb-2">

<label>Confirmar senha</label>
<input type="password" name="confirmar_senha" class="form-control mb-2">

<small class="text-muted">
Deixe em branco se não quiser alterar.
</small>

</div>

</div>

<br>

<button class="btn btn-success">
Salvar Alterações
</button>


<script>

document.addEventListener("DOMContentLoaded", function(){

const campo = document.getElementById("cpf_cnpj");

if(!campo) return;

campo.addEventListener("input", function(e){

let v = e.target.value.replace(/\D/g,'');

if(v.length <= 11){

v = v.replace(/(\d{3})(\d)/,"$1.$2");
v = v.replace(/(\d{3})(\d)/,"$1.$2");
v = v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");

}else{

v = v.replace(/^(\d{2})(\d)/,"$1.$2");
v = v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
v = v.replace(/\.(\d{3})(\d)/,".$1/$2");
v = v.replace(/(\d{4})(\d)/,"$1-$2");

}

e.target.value = v;

});

});

</script>
</form>