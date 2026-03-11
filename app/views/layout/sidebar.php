<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nivel = $_SESSION['usuario_nivel'] ?? '';

require_once BASE_PATH . "/app/models/Configuracao.php";

$modelConfig = new Configuracao();
$configSistema = $modelConfig->get();

?>

<div class="sidebar">

<div class="logo-area">

<?php if(!empty($configSistema['logo'])): ?>

<img src="<?= BASE_URL ?>/assets/img/<?= $configSistema['logo'] ?>" class="logo-sidebar">

<?php else: ?>

<img src="<?= BASE_URL ?>/assets/img/logo.png" class="logo-sidebar">

<?php endif; ?>

</div>


<!-- DASHBOARD -->
<a href="<?= BASE_URL ?>/dashboard">
<i class="bi bi-speedometer2"></i> Dashboard
</a>


<!-- CLÍNICA -->
<div class="menu-section">CLÍNICA</div>

<?php if($nivel == 'admin' || $nivel == 'recepcao' || $nivel == 'dentista'): ?>

<a href="<?= BASE_URL ?>/pacientes">
<i class="bi bi-people"></i> Pacientes
</a>

<a href="<?= BASE_URL ?>/consultas">
<i class="bi bi-calendar-check"></i> Agenda
</a>

<?php endif; ?>


<?php if($nivel == 'admin' || $nivel == 'dentista' || $nivel == 'auxiliar'): ?>

<a href="<?= BASE_URL ?>/prontuarios">
<i class="bi bi-heart-pulse"></i> Prontuários
</a>

<?php endif; ?>


<!-- FINANCEIRO -->
<?php if($nivel == 'admin' || $nivel == 'dentista'): ?>

<div class="menu-section">FINANCEIRO</div>

<a href="<?= BASE_URL ?>/financeiro/receber">
<i class="bi bi-cash-coin"></i> Contas a Receber
</a>

<a href="<?= BASE_URL ?>/financeiro/comissoes">
<i class="bi bi-currency-dollar"></i> Comissões
</a>

<?php endif; ?>


<!-- ESTOQUE -->
<?php if($nivel == 'admin'): ?>

<div class="menu-section">ESTOQUE</div>

<a href="<?= BASE_URL ?>/fornecedores">
<i class="bi bi-truck"></i> Fornecedores
</a>

<a href="<?= BASE_URL ?>/produtos">
<i class="bi bi-box"></i> Produtos
</a>

<a href="<?= BASE_URL ?>/compras">
<i class="bi bi-cart"></i> Compras
</a>

<?php endif; ?>


<!-- SISTEMA -->
<?php if($nivel == 'admin'): ?>

<div class="menu-section">SISTEMA</div>

<a href="<?= BASE_URL ?>/usuarios">
<i class="bi bi-person-gear"></i> Usuários
</a>

<a href="<?= BASE_URL ?>/configuracoes">
<i class="bi bi-sliders"></i> Configurações
</a>

<?php endif; ?>


<!-- SAIR -->
<a href="<?= BASE_URL ?>/login/logout">
<i class="bi bi-box-arrow-right"></i> Sair
</a>

</div>