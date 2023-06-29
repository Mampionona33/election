<?php
// Gestion des erreurs probables

use Api\CandidatApi;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require_once './lib/Autoload.class.php';

final class App
{
    private $router;
    private $userController;
    private $candidatApi;

    function __construct()
    {
        $autoload = new lib\Autoload();
        spl_autoload_register([$autoload, 'loadClass']);
        $this->router = new router\Router();
        $this->userController = new controller\UserController();
        $this->candidatApi = new CandidatApi();
    }

    public function __invoke()
    {
        session_save_path(__DIR__ . "/tmp");
        session_start();
        // echo session_save_path();

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
        $this->router->post("/api/entry", [$this->candidatApi, "handleCreate"]);
        $this->router->get("/api/entry", [$this->candidatApi, "handleCreate"]);

        $this->router->handleRequest();
    }
}

$app = new App();
$app();
