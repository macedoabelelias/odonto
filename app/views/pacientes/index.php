<h4 class="mb-4">Pacientes</h4>

<a href="<?= BASE_URL ?>/pacientes/criar" class="btn btn-primary mb-3">
    Novo Paciente
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th width="260">Ações</th>
        </tr>
    </thead>
    <tbody>

        <?php if(!empty($pacientes)): ?>
            <?php foreach($pacientes as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['cpf']) ?></td>
                    <td><?= htmlspecialchars($p['telefone']) ?></td>
                    <td>

                        <!-- PRONTUÁRIO -->
                        <a href="<?= BASE_URL ?>/prontuarios/index/<?= $p['id'] ?>"
                            class="btn btn-info btn-sm">
                                Prontuário
                        </a>

                        <!-- EDITAR -->
                        <a href="<?= BASE_URL ?>/pacientes/editar/<?= $p['id'] ?>"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <!-- EXCLUIR -->
                        <a href="<?= BASE_URL ?>/pacientes/excluir/<?= $p['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Tem certeza que deseja excluir este paciente?');">
                            Excluir
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">
                    Nenhum paciente cadastrado.
                </td>
            </tr>
        <?php endif; ?>

    </tbody>
</table>