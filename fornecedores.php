<?php
require_once("config/conexao.php");
require_once("layout/header.php");
require_once("layout/sidebar.php");
require_once("layout/navbar.php");

$sql = $pdo->query("SELECT * FROM fornecedores ORDER BY id DESC");
$fornecedores = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Fornecedores</h4>
        <a href="fornecedor_novo.php" class="btn btn-primary">Novo Fornecedor</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Telefone</th>
                <th>Status</th>
                <th width="160">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fornecedores as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['nome']) ?></td>
                <td><?= $f['cnpj'] ?></td>
                <td><?= $f['telefone'] ?></td>
                <td><?= $f['status'] ?></td>
                <td>
                    <a href="fornecedor_editar.php?id=<?= $f['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="fornecedor_excluir.php?id=<?= $f['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Deseja excluir?')">
                       Excluir
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php require_once("layout/footer.php"); ?>