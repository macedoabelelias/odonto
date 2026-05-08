<div class="container mt-4" style="max-width: 700px;">

<h4>💰 Nova Conta a Receber</h4>

<form method="POST" action="?url=contasReceber/salvar" class="card p-4 shadow-sm">

    <!-- PACIENTE -->
    <div class="mb-3">
        <label>Paciente</label>
        <select name="paciente_id" class="form-control" required>
            <option value="">Selecione o paciente</option>
            <?php foreach($pacientes as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- DENTISTA -->
    <div class="mb-3">
        <label>Dentista</label>
        <select name="profissional_id" class="form-control" required>
            <option value="">Selecione o dentista</option>
            <?php foreach($dentistas as $d): ?>
                <option value="<?= $d['id'] ?>">
                    <?= htmlspecialchars($d['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- 🔥 CONVÊNIO (NOVO) -->
    <div class="mb-3">
        <label>Convênio</label>
        <select name="convenio_id" class="form-control">
            <option value="">Particular</option>
            <?php foreach($convenios as $c): ?>
                <option value="<?= $c['id'] ?>">
                    <?= htmlspecialchars($c['nome']) ?> (<?= $c['percentual'] ?>%)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- DESCRIÇÃO -->
    <div class="mb-3">
        <label>Descrição</label>
        <input type="text" name="descricao" class="form-control" required>
    </div>

    <!-- VALOR + DATA -->
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

    <!-- BOTÕES -->
    <div class="d-flex gap-2 mt-2">
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="?url=contasReceber" class="btn btn-secondary">Voltar</a>
    </div>

</form>

</div>