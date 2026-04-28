<?php

class Controller {

    protected $pdo;

    public function __construct(){

        require BASE_PATH . "/config/conexao.php";

        $this->pdo = $pdo;

    }

    protected function view($view, $data = [], $layout = "layout"){

        extract($data);

        $viewFile = BASE_PATH . "/app/views/" . $view . ".php";

        if($layout == "layout_login"){

            require BASE_PATH . "/app/views/layout/layout_login.php";

        } else if($layout == "layout"){

            require BASE_PATH . "/app/views/layout/header.php";
            require $viewFile;
            require BASE_PATH . "/app/views/layout/footer.php";

        } else {

            require $viewFile;

        }

    }

    protected function verificarAdmin()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(($_SESSION['usuario_nivel'] ?? '') != 'administrador'){
        die("Acesso negado.");
    }
}



}