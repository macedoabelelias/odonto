<?php
require_once 'config/conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nivel = $_SESSION['usuario_nivel'] ?? '';

$configSistema = $pdo->query("SELECT * FROM configuracoes LIMIT 1")
                     ->fetch(PDO::FETCH_ASSOC);
?>

<div class="sidebar">

    <div class="logo-area">
        <?php if(!empty($configSistema['logo'])): ?>
            <img src="/odonto/uploads/<?= $configSistema['logo'] ?>" class="logo-sidebar">
        <?php else: ?>
            <h4><?= $configSistema['nome_clinica'] ?></h4>
        <?php endif; ?>
    </div>

    <!-- DASHBOARD (Todos logados) -->
    <a href="dashboard.php">Dashboard</a>

    <!-- RECEPÇÃO E ADMIN -->
    <?php if($nivel == 'admin' || $nivel == 'recepcao'): ?>
        <a href="pacientes.php">Pacientes</a>
        <a href="agendamentos.php">Agendamentos</a>
    <?php endif; ?>

    <!-- DENTISTA -->
    <?php if($nivel == 'admin' || $nivel == 'dentista'): ?>
        <a href="consultas.php">Consultas</a>
    <?php endif; ?>

    <!-- FINANCEIRO (Admin + Auxiliar) -->
    <?php if($nivel == 'admin' || $nivel == 'auxiliar'): ?>
        <a href="financeiro.php">Financeiro</a>
        <a href="relatorios.php">Relatórios</a>
    <?php endif; ?>

    <!-- ESTOQUE (Somente Admin) -->
    <?php if($nivel == 'admin'): ?>
        <div class="menu-section">ESTOQUE</div>

        <a href="fornecedores.php">Fornecedores</a>
        <a href="produtos.php">Produtos</a>
        <a href="compras.php">Compras</a>
    <?php endif; ?>

    <a href="logout.php">Sair</a>

</div>