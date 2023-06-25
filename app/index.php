<?php
// Gestion des erreurs probables
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require_once './lib/Autoload.class.php';

final class App
{
    private $router;
    private $userController;

    function __construct()
    {
        $autoload = new lib\Autoload();
        spl_autoload_register([$autoload, 'loadClass']);
        $this->router = new router\Router();
    }

    public function __invoke()
    {
        session_start();

        $this->router->get("/", function () {

            $this->userController = new controller\UserController();

            // Vérifier si l'utilisateur est connecté
            if ($this->userController->isUserLogged()) {
                echo "Bienvenue, utilisateur connecté !";
            } else {
                echo "Veuillez vous connecter.";
            }
        });

        $this->router->handleRequest();
    }
}

$app = new App();
$app();
