<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
$nivel = $_SESSION['usuario_nivel'] ?? '';
?>

<div class="topbar">

    <div class="fw-semibold">
        Painel Administrativo
    </div>

    <div class="d-flex align-items-center gap-4">

        <?php if($nomeUsuario): ?>
            <div class="user-info">

                <!-- Avatar com inicial -->
                <div class="user-avatar">
                    <?= strtoupper(substr($nomeUsuario, 0, 1)) ?>
                </div>

                <div class="user-text">
                    <div class="user-name">
                        <?= htmlspecialchars($nomeUsuario) ?>
                    </div>
                    <div class="user-level">
                        <?= strtoupper($nivel) ?>
                    </div>
                </div>

            </div>
        <?php endif; ?>

        <!-- BOTÃO CONFIGURAÇÕES -->
        <div class="position-relative">

            <button id="btnConfig" class="config-btn">
                <i class="bi bi-gear-fill"></i>
            </button>

            <div id="menuConfig" class="config-menu">

                <!-- ADMIN -->
                <?php if($nivel === 'admin'): ?>

                    <a href="usuarios.php">
                        <i class="bi bi-people me-2"></i> Gerenciar Usuários
                    </a>

                    <a href="configuracoes.php">
                        <i class="bi bi-sliders me-2"></i> Personalização
                    </a>

                <!-- OUTROS USUÁRIOS -->
                <?php else: ?>

                    <a href="meu_perfil.php">
                        <i class="bi bi-person me-2"></i> Meu Perfil
                    </a>

                <?php endif; ?>

                <a href="logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                </a>

            </div>

        </div>

    </div>

</div>

<div class="page-wrapper">

<script>
document.addEventListener("DOMContentLoaded", function(){

    const btn = document.getElementById("btnConfig");
    const menu = document.getElementById("menuConfig");

    if(btn){
        btn.addEventListener("click", function(e){
            e.stopPropagation();
            menu.classList.toggle("show");
        });

        document.addEventListener("click", function(){
            menu.classList.remove("show");
        });
    }

});
</script>