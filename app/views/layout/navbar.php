<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
$nivel = $_SESSION['usuario_nivel'] ?? '';
$fotoUsuario = $_SESSION['usuario_foto'] ?? '';

$fotoPath = BASE_URL . "/assets/img/usuarios/" . $fotoUsuario;

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div class="topbar">

    <div class="fw-semibold">
        Painel Administrativo
    </div>

    <div class="d-flex align-items-center gap-4">

        <?php if($nomeUsuario): ?>

        <div class="user-info d-flex align-items-center">

            <?php if(!empty($fotoUsuario) && file_exists(BASE_PATH."/public/assets/img/usuarios/".$fotoUsuario)): ?>

                <img src="<?= $fotoPath ?>" class="user-photo">

            <?php else: ?>

                <div class="user-avatar">
                    <?= strtoupper(substr($nomeUsuario, 0, 1)) ?>
                </div>

            <?php endif; ?>

            <div class="user-text ms-2">

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

            <div id="menuConfig" class="config-menu shadow">

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

                <div class="dropdown-divider"></div>

                <a href="<?= BASE_URL ?>/login/logout" class="text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                </a>

            </div>

        </div>

    </div>

</div>

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