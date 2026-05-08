<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/odonto/public');

require_once BASE_PATH . "/core/Controller.php";
require_once BASE_PATH . "/core/Model.php";
require_once BASE_PATH . "/core/Router.php";


$router = new Router();
$router->run();


?>