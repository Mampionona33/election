<?php
// Gestion des erreurs probables
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require_once './lib/Autoload.class.php';

final class App
{
    private $router;

    function __construct()
    {
        $autoload = new lib\Autoload();
        spl_autoload_register([$autoload, 'loadClass']);
        $this->router = new router\Router();
    }

    public function __invoke()
    {
        $this->router->get("/", function () {
            echo "test";
        });

        $this->router->handleRequest();
    }
}

$app = new App();
$app();
