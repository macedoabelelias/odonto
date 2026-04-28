

<h4 class="mb-4">Pacientes</h4>

<?php $pacientes = is_array($pacientes ?? null) ? $pacientes : []; ?>

<?php
$nivel = $_SESSION['usuario_nivel'] ?? '';

// 🔢 Contadores
$total = count($pacientes);
$ativos = count(array_filter($pacientes, function($p){
    return ($p['status'] ?? 'ativo') == 'ativo';
}));
$inativos = $total - $ativos;
?>

<div class="row mb-3">

    <div class="col-md-4">
        <div class="card border-success shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-success mb-1">Ativos</h6>
                <h4 class="mb-0"><?= $ativos ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-danger shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-danger mb-1">Inativos</h6>
                <h4 class="mb-0"><?= $inativos ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-primary shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-primary mb-1">Total</h6>
                <h4 class="mb-0"><?= $total ?></h4>
            </div>
        </div>
    </div>

</div>

<!-- ==========================
     BUSCA + NOVO PACIENTE
========================== -->
<form method="GET" action="<?= BASE_URL ?>/pacientes" class="row mb-3">

<div class="col-md-4">
<input type="text"
name="busca"
class="form-control"
placeholder="Buscar por nome ou CPF"
value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
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

<!-- 🔥 AQUI ENTRA O FILTRO -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>/pacientes?status=ativo" class="btn btn-success btn-sm">Ativos</a>
    <a href="<?= BASE_URL ?>/pacientes?status=todos" class="btn btn-secondary btn-sm">Todos</a>
</div>

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
<th>Dentista</th>
<th>Status</th>
<th width="320">Ações</th>
</tr>
</thead>

<tbody>

<?php if(!empty($pacientes)): ?>

<?php foreach($pacientes as $p): ?>

<?php
$idade = '-';

if(!empty($p['data_nascimento'])){
    $dataNasc = new DateTime($p['data_nascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNasc)->y . " anos";
}

$status = $p['status'] ?? 'ativo';
?>

<tr class="<?= ($status == 'inativo') ? 'bg-light text-muted opacity-50' : '' ?>">

<!-- FOTO -->
<td>

<?php if(!empty($p['foto'])): ?>

<img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($p['foto']) ?>"
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

<!-- DENTISTA -->
<td><?= htmlspecialchars($p['profissional'] ?? '-') ?></td>

<!-- STATUS -->
<td>
<?php if($status == 'ativo'): ?>
    <span class="badge bg-success">Ativo</span>
<?php else: ?>
    <span class="badge bg-danger">Inativo</span>
<?php endif; ?>
</td>

<!-- AÇÕES -->
<td>

<?php if($nivel == 'dentista' || $nivel == 'administrador' || $nivel == 'admin'): ?>

<a href="<?= BASE_URL ?>/prontuarios/index/<?= $p['id'] ?>"
class="btn btn-info btn-sm">
Prontuário
</a>

<?php else: ?>

<a href="<?= BASE_URL ?>/consultas/criar?paciente=<?= $p['id'] ?>"
class="btn btn-success btn-sm">
Agendar
</a>

<?php endif; ?>

<a href="<?= BASE_URL ?>/pacientes/editar/<?= $p['id'] ?>"
class="btn btn-warning btn-sm">
Editar
</a>

<?php if(in_array($nivel, ['admin', 'administrador'])): ?>

    <?php if($status == 'ativo'): ?>

        <a href="<?= BASE_URL ?>/pacientes/inativar/<?= $p['id'] ?>"
        class="btn btn-secondary btn-sm"
        onclick="return confirm('Deseja inativar este paciente?');">
        Inativar
        </a>

    <?php else: ?>

        <a href="<?= BASE_URL ?>/pacientes/reativar/<?= $p['id'] ?>"
        class="btn btn-success btn-sm"
        onclick="return confirm('Deseja reativar este paciente?');">
        Reativar
        </a>

    <?php endif; ?>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
<td colspan="9" class="text-center">
Nenhum paciente encontrado.
</td>
</tr>

<?php endif; ?>

</tbody>
</table>