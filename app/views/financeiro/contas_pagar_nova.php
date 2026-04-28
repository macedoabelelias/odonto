<div class="container mt-4" style="max-width: 700px;">

<h4>💸 Nova Conta a Pagar</h4>

<form method="POST" action="<?= BASE_URL ?>/contasPagar/salvar" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label>Descrição</label>
        <input type="text" name="descricao" class="form-control" required>
    </div>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Valor</label>
            <input type="number" step="0.01" name="valor" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Data de Vencimento</label>
            <input type="date" name="data_vencimento" class="form-control" required>
        </div>

    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-danger">Salvar</button>
        <a href="<?= BASE_URL ?>/contasPagar" class="btn btn-secondary">Voltar</a>
    </div>

</form>

</div>