<h4 class="mb-4">Editar Paciente</h4>

<?php if(!empty($_SESSION['erro'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
    </div>
<?php endif; ?>

<form method="POST" 
      action="<?= BASE_URL ?>/pacientes/atualizar/<?= $paciente['id'] ?>" 
      enctype="multipart/form-data">

<!-- ==========================
     FOTO
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">📸 Foto do Paciente</h5>

<div class="row align-items-center">

    <div class="col-md-3 mb-3">
        <?php if(!empty($paciente['foto'])): ?>
            <img src="<?= BASE_URL ?>/uploads/<?= $paciente['foto'] ?>" 
                 width="120"
                 height="120"
                 style="object-fit:cover;border-radius:10px;">
        <?php else: ?>
            <div style="
                width:120px;
                height:120px;
                background:#e5e7eb;
                border-radius:10px;
                display:flex;
                align-items:center;
                justify-content:center;">
                Sem Foto
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4 mb-3">
        <label>Alterar Foto</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
    </div>

</div>

</div>
</div>


<!-- ==========================
     DADOS PESSOAIS
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">📌 Dados Pessoais</h5>

<?php
$idade = '';
if(!empty($paciente['data_nascimento'])){
    $nasc = new DateTime($paciente['data_nascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($nasc)->y . " anos";
}
?>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nome *</label>
        <input type="text" name="nome" class="form-control"
               value="<?= htmlspecialchars($paciente['nome']) ?>" required>
    </div>

    <div class="col-md-3 mb-3">
        <label>CPF</label>
        <input type="text" name="cpf" class="form-control"
               value="<?= htmlspecialchars($paciente['cpf']) ?>">
    </div>

    <div class="col-md-3 mb-3">
        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" class="form-control"
               value="<?= $paciente['data_nascimento'] ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-2 mb-3">
        <label>Idade</label>
        <input type="text" class="form-control" value="<?= $idade ?>" readonly>
    </div>

    <div class="col-md-3 mb-3">
        <label>Gênero</label>
        <select name="genero" class="form-control">
            <option value="">Selecione</option>
            <option value="Masculino" <?= ($paciente['genero'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
            <option value="Feminino" <?= ($paciente['genero'] == 'Feminino') ? 'selected' : '' ?>>Feminino</option>
            <option value="Outro" <?= ($paciente['genero'] == 'Outro') ? 'selected' : '' ?>>Outro</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label>Estado Civil</label>
        <input type="text" name="estado_civil" class="form-control"
               value="<?= htmlspecialchars($paciente['estado_civil']) ?>">
    </div>

    <div class="col-md-2 mb-3">
        <label>Profissão</label>
        <input type="text" name="profissao" class="form-control"
               value="<?= htmlspecialchars($paciente['profissao']) ?>">
    </div>

    <div class="col-md-2 mb-3">
        <label>Tipo Sanguíneo</label>
        <input type="text" name="tipo_sanguineo" class="form-control"
               value="<?= htmlspecialchars($paciente['tipo_sanguineo']) ?>">
    </div>
</div>

</div>
</div>


<!-- ==========================
     CONTATO
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">📞 Contato</h5>

<div class="row">
    <div class="col-md-3 mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" class="form-control"
               value="<?= htmlspecialchars($paciente['telefone']) ?>">
    </div>

    <div class="col-md-3 mb-3">
        <label>WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control"
               value="<?= htmlspecialchars($paciente['whatsapp']) ?>">
    </div>

    <div class="col-md-3 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
               value="<?= htmlspecialchars($paciente['email']) ?>">
    </div>

    <div class="col-md-3 mb-3">
        <label>Instagram</label>
        <input type="text" name="instagram" class="form-control"
               value="<?= htmlspecialchars($paciente['instagram']) ?>">
    </div>
</div>

</div>
</div>


<!-- ==========================
     ENDEREÇO
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">🏠 Endereço</h5>

<div class="row">
    <div class="col-md-3 mb-3">
        <label>CEP</label>
        <input type="text" name="cep" class="form-control"
               value="<?= htmlspecialchars($paciente['cep']) ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label>Endereço</label>
        <input type="text" name="endereco" class="form-control"
               value="<?= htmlspecialchars($paciente['endereco']) ?>">
    </div>

    <div class="col-md-3 mb-3">
        <label>Bairro</label>
        <input type="text" name="bairro" class="form-control"
               value="<?= htmlspecialchars($paciente['bairro']) ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label>Cidade</label>
        <input type="text" name="cidade" class="form-control"
               value="<?= htmlspecialchars($paciente['cidade']) ?>">
    </div>

    <div class="col-md-2 mb-3">
        <label>Estado</label>
        <input type="text" name="estado" class="form-control"
               value="<?= htmlspecialchars($paciente['estado']) ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label>Convênio</label>
        <input type="text" name="convenio" class="form-control"
               value="<?= htmlspecialchars($paciente['convenio']) ?>">
    </div>
</div>

</div>
</div>


<!-- ==========================
     OBSERVAÇÕES
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">📝 Observações</h5>

<textarea name="observacoes" class="form-control" rows="4">
<?= htmlspecialchars($paciente['observacoes']) ?>
</textarea>

</div>
</div>


<div class="text-end">
    <button type="submit" class="btn btn-success">Atualizar Paciente</button>
    <a href="<?= BASE_URL ?>/pacientes" class="btn btn-secondary">Cancelar</a>
</div>

</form>