<?php
// Gestion des erreurs probables
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require_once './lib/Autoload.class.php';

$autoload = new lib\Autoload();
spl_autoload_register([$autoload, 'loadClass']);

$router = new router\Router();

$router->get('/', function () {
    echo "test";
});

$router();
