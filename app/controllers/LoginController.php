<?php

class LoginController extends Controller {

    public function index() {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['usuario_id'])) {
        header("Location: " . BASE_URL . "/dashboard");
        exit;
    }

    $this->view("login", [], "layout_login");

}

    public function autenticar() {

    require BASE_PATH . "/config/conexao.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->execute([$email]);

    if ($sql->rowCount() > 0) {

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if ($senha == $usuario['senha']) {

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_nivel'] = $usuario['nivel'];

            header("Location: " . BASE_URL . "/dashboard");
            exit;

        }

    }

    header("Location: " . BASE_URL . "/login?erro=1");
    exit;
}

    public function logout(){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit;
    }
}