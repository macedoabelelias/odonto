<h2>Novo Produto</h2>

<form method="POST" action="<?= BASE_URL ?>/produtos/salvar">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label>Estoque Inicial</label>
            <input type="number" name="estoque" class="form-control" value="0">
        </div>

        <div class="col-md-3 mb-3">
            <label>Preço de Custo</label>
            <input type="text" name="preco_custo" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label>Preço de Venda</label>
            <input type="text" name="preco_venda" class="form-control">
        </div>

    </div>

    <button class="btn btn-success">Salvar</button>
    <a href="<?= BASE_URL ?>/produtos" class="btn btn-secondary">Voltar</a>

</form>