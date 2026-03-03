<div id="menuConfig" class="config-menu">

    <a href="<?= BASE_URL ?>/usuarios/perfil">
        <i class="bi bi-person me-2"></i> Meu Perfil
    </a>

    <?php if($nivel === 'admin'): ?>

        <a href="<?= BASE_URL ?>/usuarios">
            <i class="bi bi-people me-2"></i> Gerenciar Usuários
        </a>

        <a href="<?= BASE_URL ?>/configuracoes">
            <i class="bi bi-sliders me-2"></i> Personalização
        </a>

    <?php endif; ?>

    <a href="<?= BASE_URL ?>/login/logout">
        <i class="bi bi-box-arrow-right me-2"></i> Sair
    </a>

</div>