<div class="container" style="max-width: 500px;">

    <div class="card shadow-sm mt-4">
        <div class="card-body">

            <h5 class="mb-3">
                <?= isset($convenio) ? '✏️ Editar Convênio' : '➕ Novo Convênio' ?>
            </h5>

            <!-- 🔥 FORM CORRIGIDO -->
            <form method="POST"
                action="<?= isset($convenio) 
                    ? BASE_URL . '/convenios/atualizar/' . $convenio['id'] 
                    : BASE_URL . '/convenios/salvar' ?>">

                <!-- NOME -->
                <div class="mb-3">
                    <label>Nome do Convênio</label>
                    <input type="text" 
                           name="nome" 
                           class="form-control"
                           required
                           value="<?= $convenio['nome'] ?? '' ?>">
                </div>

                <!-- % COMISSÃO -->
                <div class="mb-3">
                    <label>% Comissão</label>
                    <input type="number" 
                           name="percentual" 
                           step="0.01"
                           class="form-control"
                           value="<?= $convenio['percentual'] ?? '' ?>">
                </div>

                <!-- VALOR US -->
                <div class="mb-3">
                    <label>Valor da US</label>
                    <input type="text" 
                           name="valor_us"
                           class="form-control"
                           value="<?= $convenio['valor_us'] ?? '' ?>">
                </div>

                <!-- BOTÕES -->
                <button type="submit" class="btn btn-success">
                    <?= isset($convenio) ? 'Atualizar' : '💾 Salvar' ?>
                </button>

                <a href="<?= BASE_URL ?>/convenios" class="btn btn-secondary">
                    Voltar
                </a>

            </form>

        </div>
    </div>

</div>