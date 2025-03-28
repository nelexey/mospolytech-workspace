<?php
// Автозагрузка классов
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class) . '.php';
    
    if (file_exists('../' . $path)) {
        require_once '../' . $path;
    }
});

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/php/mospolytech-workspace/framework/public');

var_dump(BASE_URL);


require_once BASE_PATH . '\src\core\Router.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

$router = new src\core\Router();
$router->dispatch($url); 