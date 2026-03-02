<?php if(isset($_GET['erro'])): ?>
    <div class="alert alert-danger text-center position-absolute top-0 start-50 translate-middle-x mt-3">
        Email ou senha inválidos
    </div>
<?php endif; ?>

<div class="login-card row">

    <!-- COLUNA ESQUERDA -->
    <div class="col-md-6 p-4 form-bg">

        <div class="text-center mb-3">
            <img src="<?= BASE_URL ?>/assets/img/logo9.png"
                 alt="Logo"
                 style="max-width:360px; border-radius:10px; margin-bottom:20px;
                 filter: drop-shadow(0 5px 10px rgba(0,0,0,.5));">
        </div>

        <form method="POST"
              action="<?= BASE_URL ?>/login/autenticar"
              style="margin-bottom:20px;">

            <input type="email"
                   name="email"
                   class="form-control mb-2"
                   placeholder="Seu e-mail"
                   required>

            <input type="password"
                   name="senha"
                   class="form-control mb-2"
                   placeholder="Senha"
                   required>

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <input type="checkbox" style="margin-top:20px;">
                    Lembrar-me
                </div>

                <button type="button"
                        class="btn btn-link p-0"
                        data-bs-toggle="modal"
                        data-bs-target="#modalRecuperar"
                        style="margin-top:18px;">
                    Esqueci minha senha
                </button>
            </div>

            <button type="submit"
                    class="btn btn-main w-100"
                    style="margin-top:20px;">
                Entrar
            </button>

        </form>
    </div>

    <!-- COLUNA DIREITA -->
    <div class="col-md-6 d-flex align-items-center">
        <div>
            <h2 class="fw-bold"
                style="font-size:32px; text-align:center; color:#4f46e5;">
                Gestão completa de seu Consultório ou Clínica
            </h2>
        </div>
    </div>

</div>


<!-- MODAL RECUPERAR SENHA -->
<div class="modal fade" id="modalRecuperar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" action="<?= BASE_URL ?>/recuperar/enviar">

        <div class="modal-header">
          <h5 class="modal-title">Recuperar senha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <p class="text-muted">
                Digite seu e-mail para alterar sua senha
            </p>
            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="Seu e-mail"
                   required>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-main w-100">
              Enviar
          </button>
        </div>

      </form>

    </div>
  </div>
</div>