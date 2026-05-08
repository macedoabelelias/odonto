<h2>Nova Compra</h2>

<form method="POST" action="<?= BASE_URL ?>/compras/salvar">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Fornecedor</label>
            <select name="fornecedor_id" class="form-control">
                <?php foreach ($fornecedores as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= $f['nome'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label>Data</label>
            <input type="date" name="data" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>

    </div>

    <hr>

    <h4>Itens da Compra</h4>

    <table class="table" id="tabelaItens">
        <thead>
            <tr>
                <th>Produto</th>
                <th width="120">Qtd</th>
                <th width="150">Preço</th>
                <th width="150">Subtotal</th>
                <th width="50"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button type="button" onclick="addItem()" class="btn btn-primary">
        + Adicionar Produto
    </button>

    <hr>

    <h4>Total: R$ <span id="totalTexto">0,00</span></h4>
    <input type="hidden" name="total" id="total">

    <button class="btn btn-success mt-3">Salvar Compra</button>

</form>

<!-- 🔥 SCRIPT PROFISSIONAL -->
<script>
function addItem() {
    let row = `
    <tr>
        <td>
            <select name="itens[][produto_id]" class="form-control">
                <?php foreach ($produtos as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                <?php endforeach; ?>
            </select>
        </td>

        <td>
            <input type="number" name="itens[][quantidade]" class="form-control qtd" value="1">
        </td>

        <td>
            <input type="number" step="0.01" name="itens[][preco]" class="form-control preco" value="0">
        </td>

        <td class="subtotal">0.00</td>

        <td>
            <button type="button" onclick="removerItem(this)" class="btn btn-danger btn-sm">X</button>
        </td>
    </tr>
    `;

    document.querySelector("#tabelaItens tbody").insertAdjacentHTML("beforeend", row);
}

function removerItem(btn) {
    btn.closest('tr').remove();
    calcularTotal();
}

document.addEventListener('input', function(e){
    if(e.target.classList.contains('qtd') || e.target.classList.contains('preco')){
        let row = e.target.closest('tr');

        let qtd = parseFloat(row.querySelector('.qtd').value) || 0;
        let preco = parseFloat(row.querySelector('.preco').value) || 0;

        let subtotal = qtd * preco;

        row.querySelector('.subtotal').innerText = subtotal.toFixed(2);

        calcularTotal();
    }
});

function calcularTotal(){
    let total = 0;

    document.querySelectorAll('.subtotal').forEach(el => {
        total += parseFloat(el.innerText) || 0;
    });

    document.getElementById('totalTexto').innerText = total.toFixed(2).replace('.', ',');
    document.getElementById('total').value = total.toFixed(2);
}
</script>