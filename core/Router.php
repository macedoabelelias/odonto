<?php

class Router {

    public function run() {

        $url = '/';

        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = $_GET['url'];
        }

        // limpa e separa
        $url = explode('/', trim($url, '/'));

        // ======================
        // CONTROLLER
        // ======================
        if (!empty($url[0])) {

            // 🔥 CONVERTE:
            // plano → PlanoController
            // plano-tratamento → PlanoTratamentoController
            // planotratamento → PlanotratamentoController (fallback simples)
            $controllerBase = str_replace(' ', '', ucwords(str_replace('-', ' ', $url[0])));

            $controllerName = $controllerBase . 'Controller';

        } else {
            $controllerName = 'DashboardController';
        }

        $controllerFile = BASE_PATH . "/app/controllers/" . $controllerName . ".php";

        // 🔥 fallback se controller não existir
        if (!file_exists($controllerFile)) {

            // tenta versão com primeira letra maiúscula simples
            $controllerName = ucfirst($url[0] ?? '') . 'Controller';
            $controllerFile = BASE_PATH . "/app/controllers/" . $controllerName . ".php";

            // fallback final
            if (!file_exists($controllerFile)) {
                $controllerName = 'DashboardController';
                $controllerFile = BASE_PATH . "/app/controllers/" . $controllerName . ".php";
            }
        }

        require_once $controllerFile;

        $controller = new $controllerName();

        // ======================
        // ACTION
        // ======================
        $action = !empty($url[1]) ? $url[1] : 'index';

        // 🔥 fallback se método não existir
        if (!method_exists($controller, $action)) {
            $action = 'index';
        }

        // ======================
        // PARAMS
        // ======================
        $params = array_slice($url, 2);

        // ======================
        // EXECUTA
        // ======================
        call_user_func_array([$controller, $action], $params);
    }
}