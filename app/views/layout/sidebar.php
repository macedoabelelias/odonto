<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔥 NORMALIZAÇÃO
$nivel = strtolower(trim($_SESSION['usuario_nivel'] ?? ''));

require_once BASE_PATH . "/app/models/Configuracao.php";

$modelConfig = new Configuracao();
$configSistema = $modelConfig->get();

?>

<div class="sidebar">

    <!-- LOGO -->
    <div class="logo-area">
        <?php if(!empty($configSistema['logo'])): ?>
            <img src="<?= BASE_URL ?>/assets/img/<?= htmlspecialchars($configSistema['logo']) ?>" class="logo-sidebar">
        <?php else: ?>
            <img src="<?= BASE_URL ?>/assets/img/logo.png" class="logo-sidebar">
        <?php endif; ?>
    </div>

    <!-- DASHBOARD -->
    <a href="<?= BASE_URL ?>/dashboard">🏠 Dashboard</a>


    <!-- ================= CLÍNICA ================= -->
    <?php if(in_array($nivel,['administrador','recepcao','recepcionista','dentista','acd'])): ?>

        <div class="menu-section">CLÍNICA</div>

        <a href="<?= BASE_URL ?>/pacientes">👥 Pacientes</a>
        <a href="<?= BASE_URL ?>/consultas">📅 Agenda</a>

        <?php if(in_array($nivel,['administrador','dentista'])): ?>
            <a href="<?= BASE_URL ?>/procedimentos">🦷 Procedimentos</a>
        <?php endif; ?>

        <!-- 🔥 CONVÊNIOS (CORRIGIDO) -->
        <?php if(in_array($nivel,['administrador','financeiro'])): ?>
            <a href="<?= BASE_URL ?>/convenios">🏥 Convênios</a>
        <?php endif; ?>

    <?php endif; ?>


    <!-- ================= FINANCEIRO ================= -->

    <!-- ADMIN / FINANCEIRO -->
    <?php if(in_array($nivel,['administrador','financeiro'])): ?>

        <div class="menu-section">FINANCEIRO</div>

        <a href="<?= BASE_URL ?>/financeiro">💰 Gestão Financeira</a>
        <a href="<?= BASE_URL ?>/contasReceber">📥 Contas a Receber</a>
        <a href="<?= BASE_URL ?>/contasPagar">💸 Contas a Pagar</a>
        <a href="<?= BASE_URL ?>/caixa">🏦 Caixa</a>
        <a href="<?= BASE_URL ?>/comissoes">📊 Comissões</a>
        <a href="<?= BASE_URL ?>/comissoes/ranking">🏆 Ranking Dentistas</a>

    <?php endif; ?>


    <!-- RECEPÇÃO -->
    <?php if(in_array($nivel,['recepcao','recepcionista'])): ?>

        <div class="menu-section">FINANCEIRO</div>

        <a href="<?= BASE_URL ?>/contasReceber">📥 Contas a Receber</a>

    <?php endif; ?>


    <!-- 🔥 ACD -->
    <?php if($nivel == 'acd'): ?>

        <div class="menu-section">FINANCEIRO</div>

        <a href="<?= BASE_URL ?>/contasReceber">📥 Contas a Receber</a>
        <a href="<?= BASE_URL ?>/contasPagar">💸 Contas a Pagar</a>

    <?php endif; ?>


    <!-- 🦷 DENTISTA -->
    <?php if($nivel == 'dentista'): ?>

        <div class="menu-section">MINHA PRODUÇÃO</div>
       
        <a href="<?= BASE_URL ?>/comissoes">📊 Minhas Comissões</a>
        <a href="<?= BASE_URL ?>/comissoes/ranking">🏆 Ranking Dentistas</a>

    <?php endif; ?>


    <!-- ================= ESTOQUE ================= -->
    <?php if(in_array($nivel,['administrador','recepcao','recepcionista'])): ?>

        <div class="menu-section">ESTOQUE</div>

        <a href="<?= BASE_URL ?>/fornecedores">🚚 Fornecedores</a>
        <a href="<?= BASE_URL ?>/produtos">📦 Produtos</a>
        <a href="<?= BASE_URL ?>/compras">🛒 Compras</a>

    <?php endif; ?>


    <!-- ================= SISTEMA ================= -->
    <?php if($nivel == 'administrador'): ?>

        <div class="menu-section">SISTEMA</div>

        <a href="<?= BASE_URL ?>/usuarios">👤 Usuários</a>
        <a href="<?= BASE_URL ?>/niveis">🔐 Níveis</a>

    <?php endif; ?>


    <!-- SAIR -->
    <a href="<?= BASE_URL ?>/login/logout">🚪 Sair</a>

</div>