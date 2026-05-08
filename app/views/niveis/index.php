<div class="container mt-4">

    <h2 class="mb-3">🔐 Níveis de Usuário</h2>

    <a href="<?= BASE_URL ?>/niveis/criar" class="btn btn-primary mb-3">
        + Novo Nível
    </a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th width="150">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($niveis as $n): ?>
                <tr>
                    <td><?= $n['id'] ?></td>
                    <td><?= ucfirst($n['nome']) ?></td>
                    <td><?= $n['descricao'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/niveis/editar/<?= $n['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?= BASE_URL ?>/niveis/excluir/<?= $n['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>