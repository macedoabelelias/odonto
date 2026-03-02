<?php

class LoginController extends Controller {

    // 🔹 Tela de login
    public function index() {

        // Se já estiver logado, vai para dashboard
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "/dashboard");
            exit;
        }

        $this->view("login", [], "layout_login");
    }

    // 🔹 Processa login
    public function autenticar() {

        require_once BASE_PATH . "/config/conexao.php";

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['email'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

        // Validação básica
        if (empty($email) || empty($senha)) {
            header("Location: " . BASE_URL . "/login?erro=1");
            exit;
        }

        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $usuario = $sql->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $usuario['senha'])) {

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_nivel'] = $usuario['nivel'];

                header("Location: " . BASE_URL . "/dashboard");
                exit;

            } else {
                header("Location: " . BASE_URL . "/login?erro=1");
                exit;
            }

        } else {
            header("Location: " . BASE_URL . "/login?erro=1");
            exit;
        }
    }

    // 🔹 Logout
    public function logout() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit;
    }
}