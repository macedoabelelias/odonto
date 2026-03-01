<?php
require_once("config/conexao.php");
require_once("layout/header.php");
require_once("layout/navbar.php");
require_once("layout/sidebar.php");

$fornecedores = $pdo->query("SELECT * FROM fornecedores WHERE status='Ativo'")
                    ->fetchAll(PDO::FETCH_ASSOC);

$produtos = $pdo->query("SELECT * FROM produtos WHERE status='Ativo'")
                ->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h3>Nova Compra</h3>

    <form method="POST" action="compra_salvar.php">

        <div class="row">

            <div class="col-md-6 mb-2">
                <label>Fornecedor</label>
                <select name="fornecedor_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php foreach($fornecedores as $f): ?>
                        <option value="<?= $f['id'] ?>">
                            <?= $f['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-2">
                <label>Produto</label>
                <select name="produto_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php foreach($produtos as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3 mb-2">
                <label>Quantidade</label>
                <input type="number" name="quantidade" class="form-control" required>
            </div>

            <div class="col-md-3 mb-2">
                <label>Valor Unitário</label>
                <input type="text" name="valor_unitario" class="form-control" required>
            </div>

            <div class="col-md-3 mb-2">
                <label>Data da Compra</label>
                <input type="date" name="data_compra" class="form-control" required>
            </div>

        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="compras.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php require_once("layout/footer.php"); ?>