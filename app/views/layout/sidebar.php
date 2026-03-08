<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nivel = $_SESSION['usuario_nivel'] ?? '';

// Proteção caso não exista configuração
if(!isset($configSistema) || !$configSistema){
    $configSistema = [
        'nome_clinica' => 'Clínica',
        'logo' => null
    ];
}
?>

<div class="sidebar">

    <div class="logo-area">

        <?php if(!empty($configSistema['logo'])): ?>

            <img src="<?= BASE_URL ?>/assets/img/<?= $configSistema['logo'] ?>"
                 class="logo-sidebar"  style="border-radius:10px;">

        <?php else: ?>

            <img src="<?= BASE_URL ?>/assets/img/logo9.png"
                 class="logo-sidebar">

        <?php endif; ?>

    </div>

    <a href="<?= BASE_URL ?>/dashboard">Dashboard</a>

    <?php if($nivel == 'admin' || $nivel == 'recepcao'): ?>
        <a href="<?= BASE_URL ?>/pacientes">Pacientes</a>
        <a href="<?= BASE_URL ?>/agendamentos">Agendamentos</a>
    <?php endif; ?>

    <?php if($nivel == 'admin' || $nivel == 'dentista'): ?>
        <a href="<?= BASE_URL ?>/consultas">Consultas</a>
    <?php endif; ?>

    <?php if($nivel == 'admin' || $nivel == 'auxiliar'): ?>
        <a href="<?= BASE_URL ?>/financeiro">Financeiro</a>
        <a href="<?= BASE_URL ?>/relatorios">Relatórios</a>
    <?php endif; ?>

    <?php if($nivel == 'admin'): ?>

        <div class="menu-section">ESTOQUE</div>

        <a href="<?= BASE_URL ?>/fornecedores">Fornecedores</a>
        <a href="<?= BASE_URL ?>/produtos">Produtos</a>
        <a href="<?= BASE_URL ?>/compras">Compras</a>

    <?php endif; ?>

    <a href="<?= BASE_URL ?>/login/logout">Sair</a>

</div>