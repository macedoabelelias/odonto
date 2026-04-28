<h4 class="mb-4">Editar Usuário</h4>

<?php if(!empty($_SESSION['erro'])): ?>
<div style="background:#ff4d4d;color:#fff;padding:10px;border-radius:6px;">
    <?= $_SESSION['erro'] ?>
</div>
<?php unset($_SESSION['erro']); endif; ?>

<form method="POST" action="<?= BASE_URL ?>/usuarios/atualizar/<?= $usuario['id'] ?>" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $usuario['id'] ?? '' ?>">

<!-- FOTO -->
<div class="card shadow-sm mb-4">
<div class="card-body">

<h6>📷 Foto do Usuário</h6>

<?php if(!empty($usuario['foto'])): ?>
    <img src="<?= BASE_URL ?>/assets/img/usuarios/<?= htmlspecialchars($usuario['foto']) ?>" width="90" class="mb-3">
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
<input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>CPF / CNPJ</label>
<input type="text" name="cpf_cnpj" id="cpf_cnpj" value="<?= htmlspecialchars($usuario['cpf_cnpj'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Data nascimento</label>
<input type="date" name="data_nascimento" value="<?= $usuario['data_nascimento'] ?? '' ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Telefone</label>
<input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Nível</label>

<select name="nivel_id" class="form-control" required>
    <option value="">Selecione</option>

    <?php foreach($niveis as $n): ?>
        <option value="<?= $n['id'] ?>"
            <?= (($usuario['nivel_id'] ?? '') == $n['id']) ? 'selected' : '' ?>>
            
            <?= htmlspecialchars($n['nome']) ?>
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

<h6>📍 Endereço</h6>

<div class="row">

<div class="col-md-3">
<label>CEP</label>
<input type="text" name="cep" id="cep" value="<?= htmlspecialchars($usuario['cep'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-6">
<label>Endereço</label>
<input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($usuario['endereco'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-3">
<label>Número</label>
<input type="text" name="numero" value="<?= htmlspecialchars($usuario['numero'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Bairro</label>
<input type="text" name="bairro" id="bairro" value="<?= htmlspecialchars($usuario['bairro'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Cidade</label>
<input type="text" name="cidade" id="cidade" value="<?= htmlspecialchars($usuario['cidade'] ?? '') ?>" class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Estado</label>
<input type="text" name="estado" id="estado" value="<?= htmlspecialchars($usuario['estado'] ?? '') ?>" class="form-control mb-3">
</div>

</div>

</div>
</div>

<!-- PROFISSIONAL -->
 <div class="card shadow-sm mb-3">
<div class="card-body">
<div class="row">

<div class="col-md-4">
<label>Especialidade</label>
<input type="text" name="especialidade"
value="<?= htmlspecialchars($usuario['especialidade'] ?? '') ?>"
class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Registro CRO</label>
<input type="text" name="registro_conselho"
value="<?= htmlspecialchars($usuario['registro_conselho'] ?? '') ?>"
class="form-control mb-3">
</div>

<div class="col-md-4">
<label>Cargo</label>
<input type="text" name="cargo"
value="<?= htmlspecialchars($usuario['cargo'] ?? '') ?>"
class="form-control mb-3">
</div>

</div>
</div>  
</div>

<!-- 💰 DADOS FINANCEIROS -->
<div class="card shadow-sm mb-4">
<div class="card-body">

<h6 class="mb-3">💰 Dados Financeiros</h6>

<div class="row">

<div class="col-md-6">

<label>Forma de Recebimento</label>

<select name="forma_recebimento" class="form-control mb-3">

    <option value="">Selecione</option>

    <?php foreach($formas as $forma): ?>
        <<option value="<?= $forma['nome'] ?>"
            <?= (($usuario['forma_recebimento'] ?? '') == $forma['nome']) ? 'selected' : '' ?>>
            
            <?= htmlspecialchars($forma['nome']) ?>
        
        </option>
    <?php endforeach; ?>

</select>

</div>

<div class="col-md-6">

<label>Chave PIX</label>

<input type="text"
name="chave_pix"
value="<?= htmlspecialchars($usuario['chave_pix'] ?? '') ?>"
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