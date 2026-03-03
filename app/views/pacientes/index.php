<h4 class="mb-4">Pacientes</h4>

<!-- ==========================
     BUSCA + NOVO PACIENTE
========================== -->
<form method="GET" action="<?= BASE_URL ?>/pacientes" class="row mb-3">

    <div class="col-md-4">
        <input type="text" 
               name="busca" 
               class="form-control"
               placeholder="Buscar por nome ou CPF"
               value="<?= $_GET['busca'] ?? '' ?>">
    </div>

    <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="<?= BASE_URL ?>/pacientes" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="col-md-5 text-end">
        <a href="<?= BASE_URL ?>/pacientes/criar" class="btn btn-success">
            Novo Paciente
        </a>
    </div>

</form>


<!-- ==========================
     TABELA DE PACIENTES
========================== -->
<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Idade</th>
            <th>Convênio</th>
            <th width="300">Ações</th>
        </tr>
    </thead>

    <tbody>

    <?php if(!empty($pacientes)): ?>
        
        <?php foreach($pacientes as $p): ?>

            <?php
            // Calcular idade automaticamente
            $idade = '-';
            if(!empty($p['data_nascimento'])){
                $dataNasc = new DateTime($p['data_nascimento']);
                $hoje = new DateTime();
                $idade = $hoje->diff($dataNasc)->y . " anos";
            }
            ?>

            <tr>

                <!-- FOTO -->
                <td>
                    <?php if(!empty($p['foto'])): ?>
                        <img src="<?= BASE_URL ?>/uploads/<?= $p['foto'] ?>" 
                             width="55" 
                             height="55"
                             style="object-fit:cover;border-radius:8px;">
                    <?php else: ?>
                        <div style="
                            width:55px;
                            height:55px;
                            background:#e5e7eb;
                            border-radius:8px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:12px;">
                            Sem Foto
                        </div>
                    <?php endif; ?>
                </td>

                <!-- DADOS -->
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= htmlspecialchars($p['cpf']) ?></td>
                <td><?= htmlspecialchars($p['telefone']) ?></td>
                <td><?= $idade ?></td>
                <td><?= htmlspecialchars($p['convenio']) ?></td>

                <!-- AÇÕES -->
                <td>

                    <a href="<?= BASE_URL ?>/prontuarios/index/<?= $p['id'] ?>"
                        class="btn btn-info btn-sm">
                        Prontuário
                    </a>

                    <a href="<?= BASE_URL ?>/pacientes/editar/<?= $p['id'] ?>"
                        class="btn btn-warning btn-sm">
                        Editar
                    </a>

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
            <td colspan="7" class="text-center">
                Nenhum paciente encontrado.
            </td>
        </tr>

    <?php endif; ?>

    </tbody>
</table>