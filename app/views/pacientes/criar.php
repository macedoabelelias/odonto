<h4 class="mb-4">Novo Paciente</h4>

<?php if(!empty($_SESSION['erro'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
    </div>
<?php endif; ?>

<form method="POST" 
      action="<?= BASE_URL ?>/pacientes/salvar" 
      enctype="multipart/form-data">

<!-- ==========================
     FOTO
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">📸 Foto do Paciente</h5>

<div class="row">
    <div class="col-md-4 mb-3">
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

<div class="row">
    <div class="col-md-5 mb-3">
        <label>Nome *</label>
        <input type="text" name="nome" class="form-control" required>
    </div>

    <div class="col-md-3 mb-3">
        <label>CPF</label>
        <input type="text" name="cpf" class="form-control" maxlength="14">
    </div>

    <div class="col-md-2 mb-3">
        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" id="data_nascimento" class="form-control">
    </div>

    <div class="col-md-2 mb-3">
        <label>Idade</label>
        <input type="text" id="idade" class="form-control" readonly>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label>Gênero</label>
        <select name="genero" class="form-control">
            <option value="">Selecione</option>
            <option value="Masculino">Cis Masculino</option>
            <option value="Feminino">Cis Feminino</option>
            <option value="Transgênero">Transgênero</option>    
            <option value="Outros">Outros</option>
        </select>
    </div>

    <div class="col-md-2 mb-3">
        <label>Estado Civil</label>
        <select name="estado_civil" class="form-control">
            <option value="">Selecione</option>
            <option value="Solteiro">Solteiro(a)</option>
            <option value="Casado">Casado(a)</option>
            <option value="Divorciado">Divorciado(a)</option>
            <option value="Viúvo">Viúvo(a)</option>
            <option value="Outros">Outros</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
         <label>Escolaridade</label>    
         <select name="escolaridade" class="form-control">
            <option value="">Selecione</option>
            <option value="Ensino Fundamental">Ensino Fundamental</option>
            <option value="Ensino Médio">Ensino Médio</option>
            <option value="Superior">Superior</option>
            <option value="Pós-Graduação">Pós-Graduação</option>
        </select>
    </div>

    <div class="col-md-2 mb-3">
        <label>Profissão</label>
        <input type="text" name="profissao" class="form-control">
    </div>

    <div class="col-md-2 mb-3">
        <label>Tipo Sanguíneo</label>
        <input type="text" name="tipo_sanguineo" class="form-control">
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
        <input type="text" name="telefone" class="form-control" maxlength="15">
    </div>

    <div class="col-md-3 mb-3">
        <label>WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" maxlength="15">
    </div>

    <div class="col-md-3 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="col-md-3 mb-3">
        <label>Instagram</label>
        <input type="text" name="instagram" class="form-control">
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
       <input type="text" name="cep" class="form-control" maxlength="9">
    </div>

    <div class="col-md-6 mb-3">
        <label>Endereço</label>
        <input type="text" name="endereco" class="form-control">
    </div>

    <div class="col-md-3 mb-3">
        <label>Bairro</label>
        <input type="text" name="bairro" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label>Cidade</label>
        <input type="text" name="cidade" class="form-control">
    </div>

    <div class="col-md-2 mb-3">
        <label>Estado</label>
        <input type="text" name="estado" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Convênio</label>
        <input type="text" name="convenio" class="form-control">
    </div>
</div>

</div>
</div>

<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">🩺 Informações Médicas</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label>Alergias</label>
<textarea name="alergias" class="form-control" rows="3"></textarea>
</div>

<div class="col-md-6 mb-3">
<label>Medicamentos em uso</label>
<textarea name="medicamentos" class="form-control" rows="3"></textarea>
</div>

</div>

</div>
</div>


<!-- ==========================
     RESPONSÁVEL
========================== -->
<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">👨‍👩‍👧 Responsável</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nome do Responsável</label>
        <input type="text" name="responsavel_nome" class="form-control">
    </div>

    <div class="col-md-3 mb-3">
        <label>Telefone</label>
       <input type="text" name="responsavel_telefone" class="form-control" maxlength="15">
    </div>

    <div class="col-md-3 mb-3">
        <label>CPF</label>
        <input type="text" name="responsavel_cpf" class="form-control" maxlength="14">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="responsavel_email" class="form-control">
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

<textarea name="observacoes" class="form-control" rows="4"></textarea>

</div>
</div>


<div class="text-end">
    <button type="submit" class="btn btn-success">Salvar Paciente</button>
    <a href="<?= BASE_URL ?>/pacientes" class="btn btn-secondary">Cancelar</a>
</div>

</form>

