<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    

<?php if(isset($_GET['erro'])): ?>
    <div class="alert alert-danger text-center position-absolute top-0 start-50 translate-middle-x mt-3 shadow">
        Email ou senha inválidos
    </div>
<?php endif; ?>


<div class="login-card row shadow-lg">

    <!-- COLUNA ESQUERDA -->
    <div class="col-md-6 p-4 form-bg">

        <div class="text-center mb-4">

            <img src="<?= BASE_URL ?>/assets/img/logo9.png"
                 alt="Logo"
                 style="max-width:360px;
                 border-radius:10px;
                 filter: drop-shadow(0 5px 10px rgba(0,0,0,.4));">

        </div>


        <form method="POST"
              action="<?= BASE_URL ?>/login/autenticar">

            <input type="email"
                   name="email"
                   class="form-control mb-3"
                   placeholder="Seu e-mail"
                   required>


            <input type="password"
                   name="senha"
                   class="form-control mb-3"
                   placeholder="Senha"
                   required>



            <div class="d-flex justify-content-between align-items-center mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           name="lembrar"
                           class="form-check-input"
                           id="lembrar">

                    <label class="form-check-label" for="lembrar">
                        Lembrar-me
                    </label>

                </div>


                <button type="button"
                        class="btn btn-link p-0"
                        data-bs-toggle="modal"
                        data-bs-target="#modalRecuperar">

                    Esqueci minha senha

                </button>

            </div>



            <button type="submit"
                    class="btn btn-main w-100">

                Entrar

            </button>

        </form>

    </div>



    <!-- COLUNA DIREITA -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">

        <div>

            <h2 class="fw-bold text-center"
                style="font-size:32px; color:#4f46e5;">

                Gestão completa de seu Consultório ou Clínica

            </h2>

        </div>

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

          <button type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"></button>

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

          <button type="submit"
                  class="btn btn-main w-100">

              Enviar

          </button>

        </div>

      </form>

    </div>

  </div>

</div>