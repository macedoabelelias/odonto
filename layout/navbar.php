<div class="main">

    <div class="navbar-top">

        <div>
            <strong>Painel Administrativo</strong>
        </div>

        <div class="user-area">

            <span>
                Bem-vindo, <strong><?= $_SESSION['usuario_nome']; ?></strong>
            </span>

            <button id="btnConfig" class="btn-config">
                ⚙️
            </button>

            <div id="menuConfig" class="menu-config">
                <a href="usuarios.php">👤 Usuários</a>
                <a href="configuracoes.php">🖼️ Personalização</a>
                <a href="logout.php">🚪 Sair</a>
            </div>

        </div>

    </div>

    <div class="content">