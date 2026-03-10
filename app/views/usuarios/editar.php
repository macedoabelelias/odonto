<h4 class="mb-4">Editar Usuário</h4>

<form method="POST" action="<?= BASE_URL ?>/usuarios/atualizar" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $usuario['id'] ?>">


<!-- FOTO -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6>📷 Foto do Usuário</h6>

<?php if(!empty($usuario['foto'])): ?>

<img src="<?= BASE_URL ?>/assets/img/usuarios/<?= $usuario['foto'] ?>" width="90" class="mb-3">

<?php endif; ?>

<input type="file" name="foto" class="form-control">

</div>
</div>


<!-- DADOS PESSOAIS -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">📌 Dados Pessoais</h6>

<div class="row">

<div class="col-md-6">
<label>Nome</label>
<input type="text" name="nome" value="<?= $usuario['nome'] ?>" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Email</label>
<input type="email" name="email" value="<?= $usuario['email'] ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>CPF / CNPJ</label>
<input type="text" name="cpf_cnpj" id="cpf_cnpj" value="<?= $usuario['cpf_cnpj'] ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Data nascimento</label>
<input type="date" name="data_nascimento" value="<?= $usuario['data_nascimento'] ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Telefone</label>
<input type="text" name="telefone" id="telefone" value="<?= $usuario['telefone'] ?>" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Nível</label>

<select name="nivel" class="form-control mb-3">

<option value="admin" <?= $usuario['nivel']=="admin"?"selected":"" ?>>Administrador</option>
<option value="dentista" <?= $usuario['nivel']=="dentista"?"selected":"" ?>>Dentista</option>
<option value="recepcao" <?= $usuario['nivel']=="recepcao"?"selected":"" ?>>Recepção</option>
<option value="financeiro" <?= $usuario['nivel']=="financeiro"?"selected":"" ?>>Financeiro</option>

</select>

</div>

</div>

</div>
</div>


<!-- ENDEREÇO -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6>📍 Endereço</h6>

<div class="row">

<div class="col-md-3">
<label>CEP</label>
<input type="text" name="cep" id="cep" value="<?= $usuario['cep'] ?>" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Endereço</label>
<input type="text" name="endereco" id="endereco" value="<?= $usuario['endereco'] ?>" class="form-control mb-3">
</div>

<div class="col-md-3">
<label>Número</label>
<input type="text" name="numero" value="<?= $usuario['numero'] ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Bairro</label>
<input type="text" name="bairro" id="bairro" value="<?= $usuario['bairro'] ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Cidade</label>
<input type="text" name="cidade" id="cidade" value="<?= $usuario['cidade'] ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Estado</label>
<input type="text" name="estado" id="estado" value="<?= $usuario['estado'] ?>" class="form-control mb-3">
</div>

</div>

</div>
</div>

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">💰 Dados Financeiros</h6>

<div class="row">

<div class="col-md-6">

<label>Forma de Recebimento</label>

<select name="forma_recebimento" class="form-control mb-3">

<option value="">Selecione</option>

<option value="pix"
<?= $usuario['forma_recebimento']=="pix"?"selected":"" ?>>
PIX
</option>

<option value="transferencia"
<?= $usuario['forma_recebimento']=="transferencia"?"selected":"" ?>>
Transferência
</option>

<option value="dinheiro"
<?= $usuario['forma_recebimento']=="dinheiro"?"selected":"" ?>>
Dinheiro
</option>

<option value="cartao"
<?= $usuario['forma_recebimento']=="cartao"?"selected":"" ?>>
Cartão
</option>

</select>

</div>

<div class="col-md-6">

<label>Chave PIX</label>

<input type="text"
name="chave_pix"
value="<?= $usuario['chave_pix'] ?>"
class="form-control">

</div>

</div>

</div>
</div>

<button class="btn btn-primary">
Atualizar Usuário
</button>

<a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary">
Voltar
</a>

</form>