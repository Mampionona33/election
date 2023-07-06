<?php

namespace controller;

use controller\AuthController;
use controller\Authorization;
use template\TemplateRenderer;
use views\Login;
use views\Navbar;

class PageController
{
    private $authController;
    private $templateRenderer;
    private $navBar;
    private $authorization;
    private $loginPage;
    private $adminSideBarItem;


    public function setLoginPage(Login $loginPage): void
    {
        $this->loginPage = $loginPage;
    }

    public function getLoginPage(): Login
    {
        return $this->loginPage;
    }

    public function setAuthorization(Authorization $authorization): void
    {
        $this->authorization = $authorization;
    }

    public function getAuthorization(): Authorization
    {
        return $this->authorization;
    }

    public function setTemplateRenderer(TemplateRenderer $templateRenderer): void
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function getTemplateRenderer(): TemplateRenderer
    {
        return $this->templateRenderer;
    }

    public function setNavbar(Navbar $navBar): void
    {
        $this->navBar = $navBar;
    }

    public function getNavbar(): Navbar
    {
        return $this->navBar;
    }

    public function setAuthController(AuthController $authController): void
    {
        $this->authController = $authController;
    }

    public function getAuthController(): AuthController
    {
        return $this->authController;
    }

    public function __construct()
    {
        // $authController = new AuthController();
        // $navBar = new Navbar();
        // $templateRenderer =  new TemplateRenderer();
        // $authorization = new Authorization();

        // $this->setAuthController($authController);
        // $this->setNavbar($navBar);
        // $this->setTemplateRenderer($templateRenderer);

        $this->authController = new AuthController();
        $this->navBar = new Navbar();
        $this->templateRenderer = new TemplateRenderer();
        $this->authorization = new Authorization();
        $this->loginPage = new Login();

        $this->navBar->setAuthorization($this->authorization);
        $this->adminSideBarItem = [
            ['path' => '/admin', 'label' => 'Accueil'],
            ['path' => '/entry', 'label' => 'Gestion des candidats'],
            ['path' => '/users', 'label' => 'Gestion des utilisateurs'],
        ];
        $this->authorization->addGroupeRoles(1, "menu_button");
    }


    public function renderLoginPage(): void
    {
        echo $this->loginPage->render();
    }

    public function handleHome(): void
    {
        session_start();
        if (!empty($_SESSION) && $_SERVER['REQUEST_URI'] == '/') {
            $this->redirectToAdminHomePage();
        }
        $this->templateRenderer->setNavbarContent($this->navBar->render());
        $this->templateRenderer->setBodyContent($this->electionResult());
        echo $this->templateRenderer->render("Home");
        session_destroy();
        exit();
    }

    public function adminHomePage(): void
    {
        session_start();
        if (!$this->isUserLogged()) {
            $this->redirectToLoginPage();
        } else {
            $this->generateNavbar();
            $this->templateRenderer->setBodyContent($this->electionResult());
            echo $this->templateRenderer->render("Home");
            exit();
        }
    }


    /**
     * tools for this classe
     */
    private function redirectToAdminHomePage(): void
    {
        header("Location: /admin");
        exit();
    }

    private function electionResult(): string
    {
        return <<<HTML
        <div>test</div>
        HTML;
    }

    private function redirectToLoginPage(): void
    {
        header("Location: /login");
        session_destroy();
        exit();
    }

    private function isUserLogged(): bool
    {
        return isset($_SESSION["user"]);
    }

    private function generateNavbar(): void
    {
        if ($this->isUserLogged()) {
            $this->navBar->setMenuVisible(true);
            $this->templateRenderer->setSidebarContent($this->adminSideBarItem);
        } else {
            $this->navBar->setMenuVisible(false);
            $this->templateRenderer->setSidebarContent([]);
        }
        $this->templateRenderer->setNavbarContent($this->navBar->render());
    }
}
