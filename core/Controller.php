<?php

class Controller {

    public function view($view, $data = [], $layout = "layout") {

        extract($data);

        $viewFile = BASE_PATH . "/app/views/$view.php";
        $layoutFile = BASE_PATH . "/app/views/layout/$layout.php";

        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            require $viewFile;
        }
    }
}