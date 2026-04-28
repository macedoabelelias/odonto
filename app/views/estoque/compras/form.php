<div class="card form-container">

    <h3 class="titulo-form">🧾 Nova Compra</h3>

    <form method="POST" action="/odonto/public/compras/salvar">

        <!-- TOPO -->
        <div class="form-row">

            <div class="form-group">
                <label>Fornecedor</label>
                <select name="fornecedor_id" required>
                    <option value="">Selecione</option>
                    <?php foreach($fornecedores as $f): ?>
                        <option value="<?= $f['id'] ?>">
                            <?= $f['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Data</label>
                <input type="date" name="data" value="<?= date('Y-m-d') ?>">
            </div>

        </div>

        <hr>

        <!-- ITENS -->
        <div class="card" style="padding:15px; margin-top:10px;">

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h4>📦 Itens da Compra</h4>

                <button type="button" class="btn btn-primary btn-sm" onclick="adicionarItem()">
                    + Adicionar Produto
                </button>
            </div>

            <!-- CABEÇALHO -->
            <div class="form-row" style="font-weight:bold; font-size:13px; margin-bottom:5px; gap:10px;">
                <div style="flex:6;">Produto</div>
                <div style="flex:0.6; text-align:center;">Qtd</div>
                <div style="flex:1.2; text-align:center;">Custo</div>
                <div style="flex:1; text-align:center;">Subtotal</div>
                <div style="flex:0.4; text-align:center;">Remover</div>
            </div>

            <!-- CONTAINER -->
            <div class="itens-compra">

                <!-- LINHA BASE -->
                <div class="form-row item-linha" style="align-items:center; margin-bottom:10px; gap:10px;">

                    <div style="flex:6; display:flex; gap:5px;">
                        <select name="itens[0][produto_id]" style="flex:1;">
                            <?php foreach($produtos as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= $p['nome'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <a href="/odonto/public/produtos/criar" target="_blank"
                           class="btn btn-sm btn-secondary">+</a>
                    </div>

                    <div style="flex:0.6;">
                        <input type="number" class="qtd" name="itens[0][quantidade]" value="1">
                    </div>

                    <div style="flex:1.2;">
                        <input type="text" class="custo" name="itens[0][custo]" placeholder="0,00">
                    </div>

                    <div style="flex:1;">
                        <input type="text" class="subtotal" value="R$ 0,00" readonly>
                    </div>

                    <div style="flex:0.4;">
                        <button type="button" onclick="removerItem(this)">❌</button>
                    </div>

                </div>

            </div>

        </div>

        <!-- TOTAL -->
        <div style="margin-top:15px; text-align:right; font-size:18px;">
            <strong>Total: <span id="total-geral">R$ 0,00</span></strong>
        </div>

        <input type="hidden" name="valor_total" value="0">

        <!-- BOTÕES -->
        <div class="form-actions">
            <button class="btn btn-success">Salvar Compra</button>
            <a href="/odonto/public/compras" class="btn btn-secondary">Voltar</a>
        </div>

    </form>

</div>

<!-- SCRIPT ÚNICO E CORRETO -->
<script>
let index = 1;

// FORMATAR
function formatarMoeda(valor){
    return valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

// CONVERTER
function parseMoeda(valor){
    if(!valor) return 0;
    return parseFloat(valor.replace(/\./g, '').replace(',', '.')) || 0;
}

// CALCULAR
function calcularTotais(){

    let total = 0;

    document.querySelectorAll('.item-linha').forEach(linha => {

        const qtd = parseFloat(linha.querySelector('.qtd')?.value) || 0;
        const custo = parseMoeda(linha.querySelector('.custo')?.value);

        const subtotal = qtd * custo;

        linha.querySelector('.subtotal').value = formatarMoeda(subtotal);

        total += subtotal;
    });

    document.getElementById('total-geral').innerText = formatarMoeda(total);

    document.querySelector('input[name="valor_total"]').value = total.toFixed(2);
}

// EVENTOS
document.addEventListener('input', function(e){
    if(e.target.classList.contains('qtd') || e.target.classList.contains('custo')){
        calcularTotais();
    }
});

// ADICIONAR ITEM
function adicionarItem(){

    const container = document.querySelector('.itens-compra');

    const novaLinha = `
    <div class="form-row item-linha" style="align-items:center; margin-bottom:10px; gap:10px;">

        <div style="flex:6; display:flex; gap:5px;">
            <select name="itens[${index}][produto_id]" style="flex:1;">
                <?php foreach($produtos as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= addslashes($p['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <a href="/odonto/public/produtos/criar" target="_blank"
               class="btn btn-sm btn-secondary">+</a>
        </div>

        <div style="flex:0.6;">
            <input type="number" class="qtd" name="itens[${index}][quantidade]" value="1">
        </div>

        <div style="flex:1.2;">
            <input type="text" class="custo" name="itens[${index}][custo]" placeholder="0,00">
        </div>

        <div style="flex:1;">
            <input type="text" class="subtotal" value="R$ 0,00" readonly>
        </div>

        <div style="flex:0.4;">
            <button type="button" onclick="removerItem(this)">❌</button>
        </div>

    </div>
    `;

    container.insertAdjacentHTML('beforeend', novaLinha);
    index++;

    calcularTotais();
}

// REMOVER
function removerItem(botao){
    botao.closest('.item-linha').remove();
    calcularTotais();
}

// INICIAR
calcularTotais();
</script>