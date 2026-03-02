<?php

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);

        // Define o caminho da view
        $viewFile = BASE_PATH . "/app/views/" . $view . ".php";

        /*
        |--------------------------------------------------------------------------
        | LOGIN (usa layout_login.php)
        |--------------------------------------------------------------------------
        */
        if ($view === 'login') {
            require BASE_PATH . "/app/views/layout/layout_login.php";
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | PAINEL INTERNO
        |--------------------------------------------------------------------------
        */

        require_once BASE_PATH . "/core/Database.php";

        $pdo = Database::getConnection();
        $sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
        $configSistema = $sql->fetch(PDO::FETCH_ASSOC);

        require BASE_PATH . "/app/views/layout/layout.php";
    }
}