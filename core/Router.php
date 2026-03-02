<?php

class Router {

    public function run() {

        $url = isset($_GET['url']) && $_GET['url'] !== ''
            ? explode('/', $_GET['url'])
            : ['dashboard'];

        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = isset($url[1]) ? $url[1] : 'index';

        $controllerFile = BASE_PATH . "/app/controllers/" . $controllerName . ".php";

        if (file_exists($controllerFile)) {

            require_once $controllerFile;
            $controller = new $controllerName;

            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                echo "Método não encontrado.";
            }

        } else {
            echo "Controller não encontrado.";
        }
    }
}