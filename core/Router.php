<?php

class Router {

    public function run() {

        $url = isset($_GET['url']) && $_GET['url'] !== ''
            ? explode('/', $_GET['url'])
            : ['dashboard'];

        $controller = ucfirst($url[0]) . "Controller";
        $action     = $url[1] ?? 'index';
        $param      = $url[2] ?? null;

        $controllerFile = BASE_PATH . "/app/controllers/" . $controller . ".php";

        if (file_exists($controllerFile)) {

            require_once $controllerFile;

            $obj = new $controller();

            if (method_exists($obj, $action)) {

                if ($param !== null) {
                    $obj->$action($param);
                } else {
                    $obj->$action();
                }

            } else {
                echo "Método não encontrado";
            }

        } else {
            echo "Controller não encontrado";
        }
    }
}