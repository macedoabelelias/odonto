<form method="POST" action="?url=configuracoes/salvar" enctype="multipart/form-data">

<div class="container mt-3" style="max-width: 700px;">

    <!-- 🔥 CABEÇALHO COM LOGO -->
    <div class="d-flex align-items-center mb-3">

        <img src="<?= !empty($config['logo']) 
            ? BASE_URL . '/assets/img/' . $config['logo'] 
            : BASE_URL . '/assets/img/logo9.png'; ?>"
            style="height:50px; border-radius:8px; margin-right:10px;" style="border-radius: 8px;">

        <div>
            <strong><?= $config['nome_clinica'] ?? 'Clínica' ?></strong><br>
            <small class="text-muted">Configurações da Clínica</small>
        </div>

    </div>

    <div class="card p-3 shadow-sm">

        <h6 class="mb-3">⚙️ Dados da Clínica</h6>

        <div class="row g-2">

            <div class="col-12">
                <label>Nome da Clínica</label>
                <input type="text" name="nome_clinica" class="form-control form-control-sm"
                       value="<?= $config['nome_clinica'] ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label>CPF/CNPJ</label>
                <input type="text" name="documento" id="documento"
                       class="form-control form-control-sm"
                       value="<?= htmlspecialchars($config['documento'] ?? '') ?>">
            </div>

            <div class="col-md-6">
                <label>Telefone</label>
                <input type="text" name="telefone" id="telefone"
                       class="form-control form-control-sm"
                       value="<?= $config['telefone'] ?? '' ?>">
            </div>

            <div class="col-md-4">
                <label>CEP</label>
                <input type="text" name="cep" id="cep"
                       class="form-control form-control-sm"
                       value="<?= $config['cep'] ?? '' ?>">
            </div>

            <div class="col-md-8">
                <label>Endereço</label>
                <input type="text" name="endereco" class="form-control form-control-sm"
                       value="<?= $config['endereco'] ?? '' ?>">
            </div>

            <div class="col-md-3">
                <label>Nº</label>
                <input type="text" name="numero" class="form-control form-control-sm"
                       value="<?= $config['numero'] ?? '' ?>">
            </div>

            <div class="col-md-5">
                <label>Bairro</label>
                <input type="text" name="bairro" class="form-control form-control-sm"
                       value="<?= $config['bairro'] ?? '' ?>">
            </div>

            <div class="col-md-4">
                <label>Cidade</label>
                <input type="text" name="cidade" class="form-control form-control-sm"
                       value="<?= $config['cidade'] ?? '' ?>">
            </div>

            <div class="col-md-2">
                <label>UF</label>
                <input type="text" name="estado" class="form-control form-control-sm"
                       value="<?= $config['estado'] ?? '' ?>">
            </div>

        </div>

        <!-- LOGO UPLOAD -->
        <div class="mt-3">
            <label>Logo</label>
            <input type="file" name="logo" class="form-control form-control-sm">
        </div>

        <div class="text-end mt-3">
            <button class="btn btn-success btn-sm">💾 Salvar</button>
        </div>

    </div>

</div>

</form>

<!-- 🔥 MÁSCARAS -->
<script>
document.addEventListener("DOMContentLoaded", function(){

    const doc = document.getElementById('documento');
    if(doc){
        doc.addEventListener('input', function(e){
            let v = e.target.value.replace(/\D/g, '');

            if (v.length <= 11) {
                v = v.replace(/(\d{3})(\d)/, '$1.$2');
                v = v.replace(/(\d{3})(\d)/, '$1.$2');
                v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            } else {
                v = v.replace(/^(\d{2})(\d)/, '$1.$2');
                v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
                v = v.replace(/(\d{4})(\d)/, '$1-$2');
            }

            e.target.value = v;
        });
    }

    const tel = document.getElementById('telefone');
    if(tel){
        tel.addEventListener('input', function(e){
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
            v = v.replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = v;
        });
    }

    const cep = document.getElementById('cep');
    if(cep){
        cep.addEventListener('input', function(e){
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = v;
        });
    }

});
</script>