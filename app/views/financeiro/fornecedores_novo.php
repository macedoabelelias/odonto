<?php $fornecedores = $fornecedores ?? []; ?>

<h2>Novo Fornecedor</h2>

<form method="POST" action="<?= BASE_URL ?>/fornecedores/salvar">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>CNPJ</label>
            <input type="text" name="cnpj" id="cnpj" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label>Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="col-md-2 mb-3">
            <label>CEP</label>
            <input type="text" name="cep" id="cep" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Endereço</label>
            <input type="text" name="endereco" id="endereco" class="form-control">
        </div>

        <div class="col-md-2 mb-3">
            <label>Número</label>
            <input type="text" name="numero" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label>Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label>Cidade</label>
            <input type="text" name="cidade" id="cidade" class="form-control">
        </div>

        <div class="col-md-2 mb-3">
            <label>Estado</label>
            <input type="text" name="estado" id="estado" class="form-control">
        </div>

    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="<?= BASE_URL ?>/fornecedores" class="btn btn-secondary">Voltar</a>

</form>

<hr>

<h4>Fornecedores cadastrados</h4>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CNPJ</th>
            <th>Telefone</th>
            <th>Cidade</th>
        </tr>
    </thead>

    <tbody>

        <?php if (!empty($fornecedores)): ?>

            <?php foreach ($fornecedores as $f): ?>
                <tr>
                    <td><?= $f['nome'] ?></td>
                    <td><?= $f['cnpj'] ?></td>
                    <td><?= $f['telefone'] ?></td>
                    <td><?= $f['cidade'] ?></td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="4">Nenhum fornecedor cadastrado.</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>


<!-- 🔥 SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/imask"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // ✅ Máscaras
    IMask(document.getElementById('cnpj'), {
        mask: '00.000.000/0000-00'
    });

    IMask(document.getElementById('telefone'), {
        mask: '(00) 00000-0000'
    });

    IMask(document.getElementById('cep'), {
        mask: '00000-000'
    });

    // 🔍 BUSCAR CNPJ
    document.getElementById('cnpj').addEventListener('blur', function(){

        let cnpj = this.value.replace(/\D/g, '');

        if(cnpj.length !== 14) return;

        fetch(`https://www.receitaws.com.br/v1/cnpj/${cnpj}`)
            .then(res => res.json())
            .then(data => {

                if(data.status === "ERROR") return;

                document.getElementById('nome').value = data.nome || '';
                document.getElementById('endereco').value = data.logradouro || '';
                document.getElementById('bairro').value = data.bairro || '';
                document.getElementById('cidade').value = data.municipio || '';
                document.getElementById('estado').value = data.uf || '';
                document.getElementById('cep').value = data.cep || '';

            })
            .catch(err => console.log(err));
    });

    // 📍 BUSCAR CEP
    document.getElementById('cep').addEventListener('blur', function(){

        let cep = this.value.replace(/\D/g, '');

        if(cep.length !== 8) return;

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {

                if(data.erro) return;

                document.getElementById('endereco').value = data.logradouro || '';
                document.getElementById('bairro').value = data.bairro || '';
                document.getElementById('cidade').value = data.localidade || '';
                document.getElementById('estado').value = data.uf || '';

            })
            .catch(err => console.log(err));
    });

});
</script>