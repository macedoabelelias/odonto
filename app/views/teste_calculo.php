<h2>Teste de Cálculo</h2>

<label>Convênio:</label>
<select id="convenio">
    <option value="">Particular</option>

    <?php foreach($convenios as $c): ?>
        <option 
            value="<?= $c['id'] ?>"
            data-us="<?= $c['valor_us'] ?>"
        >
            <?= $c['nome'] ?> - US: <?= $c['valor_us'] ?>
        </option>
    <?php endforeach; ?>
</select>
</select>

<br><br>

<label>Procedimento:</label>
<select id="procedimento">
    <option value="">Selecione</option>

    <?php foreach($procedimentos as $p): ?>
        <option 
            value="<?= $p['id'] ?>"
            data-us="<?= $p['quantidade_us'] ?>"
            data-valor="<?= $p['valor_particular'] ?>"
        >
            <?= $p['nome'] ?>
        </option>
    <?php endforeach; ?>
</select>
</select>

<br><br>

<label>Valor:</label>

<input type="text" id="valor" readonly>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const convenio = document.getElementById("convenio");
    const procedimento = document.getElementById("procedimento");
    const valor = document.getElementById("valor");

    function calcular() {

        const proc = procedimento.selectedOptions[0];
        const conv = convenio.selectedOptions[0];

        if (!proc || !proc.value) {
            valor.value = "";
            return;
        }

        const quantidadeUS = parseFloat(proc.dataset.us) || 0;
        const valorParticular = parseFloat(proc.dataset.valor) || 0;

        const valorUS = parseFloat(conv.dataset.us) || 0;

        let total = 0;

        // 🔥 lógica principal
        if (convenio.value && quantidadeUS > 0) {
            total = quantidadeUS * valorUS;
        } else {
            total = valorParticular;
        }

        valor.value = total.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }

    convenio.addEventListener("change", calcular);
    procedimento.addEventListener("change", calcular);

});
</script>