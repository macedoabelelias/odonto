<style>

.container {
    max-width: 1100px;
    margin: auto;
}

.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.card h3 {
    margin-bottom: 15px;
    font-size: 16px;
    color: #333;
    border-left: 4px solid #28a745;
    padding-left: 10px;
}

.field {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 13px;
}

input, select {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn {
    padding: 10px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-success {
    background: #28a745;
    color: #fff;
}

.btn-secondary {
    background: #6c757d;
    color: #fff;
    text-decoration: none;
}

</style>


<div class="container">

<form method="POST" action="<?= BASE_URL ?>/usuarios/salvar" enctype="multipart/form-data">

<!-- ================= DADOS BÁSICOS ================= -->
<div class="card">
    <h3>Dados Básicos</h3>

    <div class="grid-3">
        <div class="field">
            <label>Nome</label>
            <input type="text" name="nome" required>
        </div>

        <div class="field">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="field">
            <label>Nível</label>
            <select name="nivel_id" required>
                <option value="">Selecione</option>
                <?php foreach($niveis as $nivel): ?>
                    <option value="<?= $nivel['id'] ?>">
                        <?= ucfirst($nivel['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="grid-2" style="margin-top:15px;">
        <div class="field">
            <label>Senha</label>
            <input type="password" name="senha">
        </div>

        <div class="field">
            <label>Foto</label>
            <input type="file" name="foto">
        </div>
    </div>
</div>


<!-- ================= DADOS PESSOAIS ================= -->
<div class="card">
    <h3>Dados Pessoais</h3>

    <div class="grid-3">
        <div class="field">
            <label>CPF/CNPJ</label>
            <input type="text" name="cpf_cnpj" id="cpf_cnpj">
        </div>

        <div class="field">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento">
        </div>

        <div class="field">
            <label>Telefone</label>
            <input type="text" name="telefone" id="telefone">
        </div>
    </div>
</div>


<!-- ================= ENDEREÇO ================= -->
<div class="card">
    <h3>Endereço</h3>

    <div class="grid-3">
        <div class="field">
            <label>CEP</label>
            <input type="text" name="cep" id="cep">
        </div>

        <div class="field">
            <label>Endereço</label>
            <input type="text" name="endereco" id="endereco">
        </div>

        <div class="field">
            <label>Número</label>
            <input type="text" name="numero">
        </div>
    </div>

    <div class="grid-3" style="margin-top:15px;">
        <div class="field">
            <label>Bairro</label>
            <input type="text" name="bairro" id="bairro">
        </div>

        <div class="field">
            <label>Cidade</label>
            <input type="text" name="cidade" id="cidade">
        </div>

        <div class="field">
            <label>Estado</label>
            <input type="text" name="estado" id="estado">
        </div>
    </div>
</div>


<!-- ================= PROFISSIONAL ================= -->
<div class="card">
    <h3>Profissional</h3>

    <div class="grid-3">
        <div class="field">
            <label>Especialidade</label>
            <input type="text" name="especialidade">
        </div>

        <div class="field">
            <label>Registro</label>
            <input type="text" name="registro_conselho">
        </div>

        <div class="field">
            <label>Cargo</label>
            <input type="text" name="cargo">
        </div>
    </div>
</div>


<!-- ================= FINANCEIRO ================= -->
<div class="card">
    <h3>Financeiro</h3>

    <div class="grid-3">
        <div class="field">
            <label>% Comissão</label>
            <input type="number" name="percentual_comissao" step="0.01" value="30">
        </div>

        <div class="field">
            <label>Forma Recebimento</label>
            <select name="forma_pagamento_id">
                <option value="">Selecione</option>
                <?php foreach($formas as $f): ?>
                    <option value="<?= $f['id'] ?>">
                        <?= $f['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label>Chave PIX</label>
            <input type="text" name="chave_pix">
        </div>
    </div>
</div>


<!-- ================= AÇÕES ================= -->
<div class="card">
    <div class="actions">
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary">Voltar</a>
    </div>
</div>

</form>

</div>

<div class="card">
    <div class="actions">
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary">Voltar</a>
    </div>
</div>

</form>

<script>

// CPF / CNPJ
document.getElementById('cpf_cnpj').addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '');

    if (v.length <= 11) {
        // CPF
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        // CNPJ
        v = v.replace(/^(\d{2})(\d)/, '$1.$2');
        v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
        v = v.replace(/(\d{4})(\d)/, '$1-$2');
    }

    e.target.value = v;
});


// TELEFONE
document.getElementById('telefone').addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '');

    if (v.length <= 10) {
        // (00) 0000-0000
        v = v.replace(/(\d{2})(\d)/, '($1) $2');
        v = v.replace(/(\d{4})(\d)/, '$1-$2');
    } else {
        // (00) 00000-0000
        v = v.replace(/(\d{2})(\d)/, '($1) $2');
        v = v.replace(/(\d{5})(\d)/, '$1-$2');
    }

    e.target.value = v;
});


// CEP
document.getElementById('cep').addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '');

    v = v.replace(/(\d{5})(\d)/, '$1-$2');

    e.target.value = v;
});

</script>

<script>

document.getElementById('cep').addEventListener('blur', function () {

    let cep = this.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        return;
    }

    fetch('https://viacep.com.br/ws/' + cep + '/json/')
        .then(res => res.json())
        .then(data => {

            if (data.erro) {
                alert('CEP não encontrado!');
                return;
            }

            document.getElementById('endereco').value = data.logradouro;
            document.getElementById('bairro').value = data.bairro;
            document.getElementById('cidade').value = data.localidade;
            document.getElementById('estado').value = data.uf;

        })
        .catch(() => {
            alert('Erro ao buscar CEP');
        });

});

<script>
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');

    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    let resto;

    for (let i = 1; i <= 9; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (11 - i);

    resto = (soma * 10) % 11;

    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;

    for (let i = 1; i <= 10; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (12 - i);

    resto = (soma * 10) % 11;

    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

document.querySelector("form").addEventListener("submit", function(e){
    let cpf = document.getElementById("cpf_cnpj").value;

    if(!validarCPF(cpf)){
        alert("CPF inválido!");
        e.preventDefault();
    }
});
</script>

</script>