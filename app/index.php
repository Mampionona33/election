<?php
// Gestion des erreurs probables

use controller\CandidatController;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require_once './lib/Autoload.class.php';

final class App
{
    private $router;
    private $userController;
    private $candidatController;

    function __construct()
    {
        $autoload = new lib\Autoload();
        spl_autoload_register([$autoload, 'loadClass']);
        $this->router = new router\Router();
        $this->userController = new controller\UserController();
        $this->candidatController = new CandidatController();
    }

    public function __invoke()
    {
        echo session_save_path();
        session_start();

        /**
         * equivalent a :
         * $this->router->get("/", function () {
         *      $this->userController->handleHome();
         * });
         */
        $this->router->get("/", [$this->userController, "handleHome"]);
        $this->router->get("/login", [$this->userController, "loginPage"]);
        $this->router->post("/login", [$this->userController, 'handleLogin']);
        $this->router->get("/logout", [$this->userController, "logout"]);
        $this->router->get("/entry", [$this->userController, "handleEntry"]);
        $this->router->post("/entry", [$this->candidatController, "handleCreate"]);

        $this->router->handleRequest();
    }
}

$app = new App();
$app();
