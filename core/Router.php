<?php

class Router {

    public function run() {

        $url = '/';

        if(isset($_GET['url']) && $_GET['url'] != ''){
            $url = $_GET['url'];
        }

        $url = explode('/', trim($url,'/'));

        $controller = !empty($url[0]) ? ucfirst($url[0]).'Controller' : 'DashboardController';
        $action = $url[1] ?? 'index';

        $params = [];

        if(count($url) > 2){
            $params = array_slice($url,2);
        }

        $controllerFile = BASE_PATH . "/app/controllers/".$controller.".php";

        if(!file_exists($controllerFile)){
            echo "Controller não encontrado";
            exit;
        }

        require_once $controllerFile;

        $obj = new $controller();

        if(!method_exists($obj,$action)){
            echo "Método não encontrado";
            exit;
        }

        call_user_func_array([$obj,$action],$params);

    }

}