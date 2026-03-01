<?php
require_once("config/conexao.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sql->execute([':email' => $email]);

    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($senha, $usuario['senha'])){

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];

        header("Location: dashboard.php");
        exit;

    } else {
        echo "Login inválido";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - Odonto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    height:100vh;
    background: linear-gradient(135deg,#eef2ff,#dbeafe,#e9d5ff);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: 'Segoe UI', sans-serif;
}

.login-card{
    background: 
        linear-gradient(rgba(255, 255, 255, 0.46), rgba(255, 255, 255, 0.45)),
        url('assets/img/fundo-login.jpg');
    background-size: cover;
    background-position: center;
    border-radius:20px;
    padding:40px;
    width:900px;
    box-shadow:0 20px 40px rgba(0,0,0,.3);
}

.btn-main{
    background:#6366f1;
    color:#fff;
    border:none;
}

.btn-main:hover{
    background:#4ed7ec;
}


</style>
</head>

<body>

<?php if(isset($_GET['erro'])): ?>
    <div class="alert alert-danger text-center position-absolute top-0 start-50 translate-middle-x mt-3">
        Email ou senha inválidos
    </div>
<?php endif; ?>

<div class="login-card row">
    <div class="col-md-6 p-4 form-bg">
        <div class="text-center mb-3">
         <img src="assets/img/logo9.png" alt="Logo" style="max-width:360px; border-radius:10px; margin-bottom:20px;
         filter: drop-shadow(0 5px 10px rgba(0,0,0,.5));" >
    </div>

        <!-- <h4 class="mb-4 text-center">Login</h4> -->

        <form method="POST" action="autenticar.php" style="margin-bottom:20px;">
            <input type="email" name="email"class="form-control mb-2" placeholder="Seu e-mail" required>
            <input class="form-control mb-2" name="senha" placeholder="Senha" type="password" required>

            <div class="d-flex justify-content-between mb-3">
                <div>

                    <input type="checkbox" style="margin-top:20px;"> Lembrar-me
                </div>

                <button type="button"
                    class="btn btn-link p-0"
                    data-bs-toggle="modal"
                    data-bs-target="#modalRecuperar"
                    style="margin-top:18px;">
                    Esqueci minha senha
                </button>
            </div>

            <button class="btn btn-main w-100" style="margin-top:20px;">Entrar</button>
        </form>
    </div>


    <div class="col-md-6 d-flex align-items-center">
        <div>
            <h2 class="fw-bold" style="font-size:32px; text-align:center; color:#4f46e5;">Gestão completa de seu Consultório ou Clínica</h2>
            
        </div>
    </div>
</div>


<!-- MODAL RECUPERAR SENHA -->
<div class="modal fade" id="modalRecuperar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" action="/odonto/enviar_recuperar.php">

        <div class="modal-header">
          <h5 class="modal-title">Recuperar senha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <p class="text-muted">Digite seu e-mail para receber alterar sua senha</p>
            <input type="email" name="email" class="form-control" placeholder="Seu e-mail" required>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-main w-100">Enviar</button>
        </div>

      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
