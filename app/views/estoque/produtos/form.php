<div class="card form-container">

    <h3 class="titulo-form">
        <?= isset($produto) ? '✏️ Editar Produto' : '📦 Novo Produto' ?>
    </h3>

    <form method="POST" action="/odonto/public/produtos/<?= isset($produto) ? 'atualizar' : 'salvar' ?>">

        <!-- 🔥 ID (ESSENCIAL PARA EDIÇÃO) -->
        <?php if(isset($produto)): ?>
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" required
                   value="<?= $produto['nome'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="descricao"><?= $produto['descricao'] ?? '' ?></textarea>
        </div>

        <div class="form-row">

            <div class="form-group">
                <label>Estoque</label>
                <input type="number" name="estoque"
                       value="<?= $produto['estoque'] ?? 0 ?>">
            </div>

            <div class="form-group">
                <label>Estoque Mínimo</label>
                <input type="number" name="estoque_minimo"
                       value="<?= $produto['estoque_minimo'] ?? 0 ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group">
                <label>Custo</label>
                <input type="text" name="custo"
                       value="<?= isset($produto['custo']) ? number_format($produto['custo'], 2, ',', '.') : '' ?>">
            </div>

            <div class="form-group">
                <label>Preço</label>
                <input type="text" name="preco"
                       value="<?= isset($produto['preco']) ? number_format($produto['preco'], 2, ',', '.') : '' ?>">
            </div>

        </div>

        <div class="form-group">
            <label>Fornecedor</label>
            <select name="fornecedor_id">
                <option value="">Selecione</option>

                <?php foreach($fornecedores as $f): ?>
                    <option value="<?= $f['id'] ?>"
                        <?= (isset($produto) && $produto['fornecedor_id'] == $f['id']) ? 'selected' : '' ?>>
                        <?= $f['nome'] ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-actions">
            <button class="btn btn-success">
                <?= isset($produto) ? 'Atualizar' : 'Salvar' ?>
            </button>

            <a href="/odonto/public/produtos" class="btn btn-secondary">
                Voltar
            </a>
        </div>

    </form>

</div>