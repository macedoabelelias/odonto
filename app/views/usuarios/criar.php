<h4 class="mb-4">Novo Usuário</h4>

<?php if(!empty($_SESSION['erro'])): ?>
<div style="background:#ff4d4d;color:#fff;padding:10px;border-radius:6px;">
    <?= $_SESSION['erro'] ?>
</div>
<?php unset($_SESSION['erro']); endif; ?>

<form method="POST" action="<?= BASE_URL ?>/usuarios/salvar" enctype="multipart/form-data">

<div class="row">

<!-- COLUNA ESQUERDA -->
<div class="col-lg-8">

<!-- DADOS PESSOAIS -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">📌 Dados Pessoais</h6>

<div class="row">

<div class="col-md-6">
<label>Nome</label>
<input type="text" name="nome" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Email</label>
<input type="email" name="email" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>CPF / CNPJ</label>
<input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Data nascimento</label>
<input type="date" name="data_nascimento" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Telefone</label>
<input type="text" name="telefone" id="telefone" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Senha</label>
<input type="password" name="senha" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Nível</label>

<select name="nivel_id" class="form-control mb-3" required> 
    <option value="">Selecione</option>
    <?php foreach($niveis as $nivel): ?>
        <option value="<?= $nivel['id'] ?>">
            <?= ucfirst($nivel['nome']) ?>
        </option>
    <?php endforeach; ?>
</select>

</div>

</div>
</div>
</div>


<!-- ENDEREÇO -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">📍 Endereço</h6>

<div class="row">

<div class="col-md-3">
<label>CEP</label>
<input type="text" name="cep" id="cep" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Endereço</label>
<input type="text" name="endereco" id="endereco" class="form-control mb-3">
</div>

<div class="col-md-3">
<label>Número</label>
<input type="text" name="numero" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Bairro</label>
<input type="text" name="bairro" id="bairro" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Cidade</label>
<input type="text" name="cidade" id="cidade" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Estado</label>
<input type="text" name="estado" id="estado" class="form-control mb-3">
</div>

</div>
</div>
</div>


<!-- PROFISSIONAL -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">🦷 Dados Profissionais</h6>

<div class="row">

<div class="col-md-4">
<label>Especialidade</label>
<input type="text" name="especialidade" class="form-control mb-3">
</div>

<div class="col-md-4">
    <label>Registro CRO</label>
    <input 
        type="text" 
        name="registro_conselho" 
        class="form-control mb-3"
        value="<?= $usuario['registro_conselho'] ?? '' ?>">
</div>

<div class="col-md-4">
<label>Cargo</label>
<input type="text" name="cargo" class="form-control mb-3">
</div>

</div>
</div>
</div>

</div>


<!-- COLUNA DIREITA -->
<div class="col-lg-4">

<!-- FOTO -->

<div class="card shadow-sm mb-4">
<div class="card-body text-center">

<h6 class="mb-3">📷 Foto do Usuário</h6>

<input type="file" name="foto" class="form-control">

</div>
</div>


<!-- FINANCEIRO -->

<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">💰 Dados Financeiros</h6>

<label>Forma de Recebimento</label>

<select name="forma_recebimento" class="form-control mb-3">
<option value="">Selecione</option>
<option value="pix">PIX</option>
<option value="transferencia">Transferência</option>
<option value="dinheiro">Dinheiro</option>
<option value="cartao">Cartão</option>
</select>

<label>Chave PIX</label>
<input type="text" name="chave_pix" class="form-control">

</div>
</div>

</div>

</div>

<button class="btn btn-success">
Salvar Usuário
</button>

<a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary">
Voltar
</a>

</form>

<!-- 🔥 SCRIPT AQUI -->
<script>
document.addEventListener("DOMContentLoaded", function(){

    const cpfInput = document.getElementById('cpf_cnpj');

    function aplicarMascara(v){
        v = v.replace(/\D/g, '');

        if(v.length <= 11){
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        return v;
    }

    if(cpfInput){

        // 🔥 aplica ao carregar (EDITAR)
        cpfInput.value = aplicarMascara(cpfInput.value);

        // 🔥 aplica enquanto digita
        cpfInput.addEventListener('input', function(e){
            e.target.value = aplicarMascara(e.target.value);
        });

    }

});
</script>