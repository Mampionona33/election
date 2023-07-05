<?php
// Gestion des erreurs probables

use Api\CandidatApi;
use controller\AuthController;
use views\Login;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require_once './lib/Autoload.class.php';

final class App
{
    private $router;
    private $userController;
    private $candidatApi;
    private $loginPage;
    private $authController;

    function __construct()
    {
        $autoload = new lib\Autoload();
        spl_autoload_register([$autoload, 'loadClass']);
        $this->router = new router\Router();
        $this->userController = new controller\UserController();
        $this->candidatApi = new CandidatApi();
        $this->setLoginPage(new Login);
        session_save_path(__DIR__ . "/tmp");
        $this->setAuthController(new AuthController);
    }

    public function setAuthController(AuthController $authController)
    {
        $this->authController = $authController;
    }

    public function setLoginPage(Login $loginPage): void
    {
        $this->loginPage = $loginPage;
    }

    public function __invoke()
    {
        /**
         * equivalent a :
         * $this->router->get("/", function () {
         *      $this->userController->handleHome();
         * });
         */
        $this->router->get("/", [$this->userController, "handleHome"]);
        $this->router->get("/login", [$this->authController, "renderLoginPage"]);
        $this->router->post("/login", [$this->authController, 'handleLogin']);
        // $this->router->get("/admin", [$this->userController, "adminHomePage"]);
        // $this->router->get("/login", [$this->userController, "loginPage"]);
        // $this->router->get("/logout", [$this->userController, "logout"]);
        // $this->router->get("/entry", [$this->userController, "handleEntry"]);
        // $this->router->post("/api/entry", [$this->candidatApi, "handleCreate"]);
        // $this->router->get("/api/entry", [$this->candidatApi, "handleGetCandidats"]);
        // $this->router->put("/api/entry", [$this->candidatApi, "handleEdit"]);

        $this->router->handleRequest();
    }
}

$app = new App();
$app();
