<div class="card form-container">

    <h3 class="titulo-form">
        <?= isset($procedimento) ? '✏️ Editar Procedimento' : '🦷 Novo Procedimento' ?>
    </h3>

    <form method="POST"
        action="<?= isset($procedimento) 
            ? BASE_URL . '/procedimentos/atualizar/' . $procedimento['id']
            : BASE_URL . '/procedimentos/salvar' ?>"
        enctype="multipart/form-data">

        <!-- NOME -->
        <div class="form-row">
            <div class="form-group" style="flex:2;">
                <label>Nome do Procedimento</label>
                <input type="text" name="nome" required
                    value="<?= $procedimento['nome'] ?? '' ?>">
            </div>
        </div>

<!-- TIPO + LOCAL + ABRANGÊNCIA -->
<div class="form-row">

    <div class="form-group">
        <label>Tipo</label>
        <select name="tipo">

            <?php
            $tipos = [
                'odontograma' => 'Odontograma',
                'geral' => 'Geral',                
            ];

            foreach($tipos as $k => $v):
            ?>

                <option value="<?= $k ?>" 
                    <?= (isset($procedimento) && $procedimento['tipo'] == $k) ? 'selected' : '' ?>>
                    <?= $v ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div class="form-group">
        <label>Local no Dente</label>
        <select name="local">
            <?php
            $locais = ['coroa','raiz','todo','geral'];
            foreach($locais as $l):
            ?>
                <option value="<?= $l ?>"
                    <?= (isset($procedimento) && $procedimento['local'] == $l) ? 'selected' : '' ?>>
                    <?= ucfirst($l) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Abrangência</label>
        <select name="abrangencia">
            <?php
            $abr = [
                'unitario' => 'Dente Individual',
                'arcada_superior' => 'Arcada Superior',
                'arcada_inferior' => 'Arcada Inferior',
                'boca_total' => 'Boca Completa'
            ];
            foreach($abr as $k => $v):
            ?>
                <option value="<?= $k ?>"
                    <?= (isset($procedimento) && $procedimento['abrangencia'] == $k) ? 'selected' : '' ?>>
                    <?= $v ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

</div>

<!-- 🔥 ÍCONE -->
<div class="form-row">
    <div class="form-group" style="width:100%;">
        <label><strong>Ícone do Procedimento</strong></label>

        <input type="file" 
               name="icone_upload" 
               id="iconeUpload" 
               class="form-control">

        <!-- 🔥 IMAGEM ATUAL (CORRIGIDA) -->
        <?php if(!empty($procedimento['icone'])): ?>

            <?php
                $icone = $procedimento['icone'];

                $caminhoFisico = BASE_PATH . "/public/assets/img/procedimentos/" . $icone;
                $caminhoWeb = BASE_URL . "/assets/img/procedimentos/" . $icone;
            ?>

            <?php if(file_exists($caminhoFisico)): ?>

                <div style="margin-top:10px;">
                    <img src="<?= $caminhoWeb ?>"
                         style="
                            width:70px;
                            height:70px;
                            object-fit:contain;
                            border-radius:10px;
                            background:#f8f9fa;
                            padding:6px;
                            border:1px solid #ddd;
                         ">
                </div>

            <?php else: ?>

                <small style="color:red;">Ícone não encontrado</small>

            <?php endif; ?>

        <?php endif; ?>

        <!-- PREVIEW NOVA -->
        <div style="margin-top:10px;">
            <img id="previewIcone" 
                 src="" 
                 style="display:none; width:70px; height:70px; border:1px solid #ddd; border-radius:8px;">
        </div>

    </div>
</div>       

        <hr>

        <!-- TUSS + VALOR -->
        <div class="form-row">

            <div class="form-group">
                <label>Código TUSS</label>
                <input type="text" name="codigo_tuss"
                    value="<?= $procedimento['codigo_tuss'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Quantidade de US</label>
                <input type="number" step="0.01" name="quantidade_us"
                    value="<?= $procedimento['quantidade_us'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Valor Particular</label>
                <input type="text" name="valor_particular"
                    value="<?= $procedimento['valor_particular'] ?? '' ?>">
            </div>

        </div>

        <!-- BOTÕES -->
        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <?= isset($procedimento) ? 'Atualizar' : 'Salvar' ?>
            </button>

            <a href="<?= BASE_URL ?>/procedimentos" class="btn btn-secondary">Voltar</a>
        </div>

    </form>

</div>

<!-- SCRIPT PREVIEW -->
<script>
document.addEventListener("DOMContentLoaded", function(){

    const input = document.getElementById("iconeUpload");
    const preview = document.getElementById("previewIcone");

    if(!input || !preview) return;

    input.addEventListener("change", function(event){

        const file = event.target.files[0];

        if(!file){
            preview.style.display = "none";
            preview.src = "";
            return;
        }

        if(!file.type.startsWith("image/")){
            alert("Selecione uma imagem válida!");
            input.value = "";
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = "block";
        };

        reader.readAsDataURL(file);
    });

});
</script>