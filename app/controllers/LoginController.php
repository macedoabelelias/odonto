<?php

class LoginController extends Controller {

    /* ==========================
       TELA DE LOGIN
    ========================== */

    public function index() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // se já estiver logado
        if (!empty($_SESSION['usuario_id'])) {

            header("Location: " . BASE_URL . "/dashboard");
            exit;
        }

        $this->view("login", [], "layout_login");
    }


    /* ==========================
       AUTENTICAR LOGIN
    ========================== */

    public function autenticar() {

        require BASE_PATH . "/config/conexao.php";

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // limpar erros anteriores
        unset($_SESSION['erro_login']);

        $email = trim($_POST['email'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

        // validação básica
        if(empty($email) || empty($senha)){

            $_SESSION['erro_login'] = "Preencha email e senha.";

            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // 🔥 LOGIN COM NÍVEL REAL
        $sql = $pdo->prepare("
            SELECT u.*, n.nome as nivel_nome
            FROM usuarios u
            LEFT JOIN niveis n ON n.id = u.nivel_id
            WHERE u.email = :email
            LIMIT 1
        ");

        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0){

            $usuario = $sql->fetch(PDO::FETCH_ASSOC);

            if(password_verify($senha, $usuario['senha'])){

                // 🧠 SESSÃO BASE
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_foto'] = $usuario['foto'];

                // 🔥 NÍVEL (TRATAMENTO COMPLETO)
                $nivel = $usuario['nivel_nome'] ?? '';

                // fallback caso não tenha nivel_id
                if(empty($nivel)){
                    $nivel = $usuario['nivel'] ?? '';
                }

                // normaliza (remove espaços e deixa minúsculo)
                $nivel = strtolower(trim($nivel));

                $_SESSION['usuario_nivel_id'] = $usuario['nivel_id'];
                $_SESSION['usuario_nivel'] = $nivel;

                header("Location: " . BASE_URL . "/dashboard");
                exit;
            }
        }

        // login inválido
        $_SESSION['erro_login'] = "Email ou senha inválidos.";

        header("Location: " . BASE_URL . "/login");
        exit;
    }


    /* ==========================
       LOGOUT
    ========================== */

    public function logout(){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit;
    }

}