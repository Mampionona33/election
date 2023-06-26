<?php

namespace controller;

use model\UserModel;
use template\TemplateRenderer;
use views\Login;
use views\Navbar;

class UserController
{
    private $userModel;
    private $templateRenderer;
    private $navBar;
    private $userLogged;
    private $login;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->templateRenderer = new TemplateRenderer();
        $this->navBar = new Navbar();
        $this->login = new Login();
    }

    private function isUserLogged(): bool
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }

    public function handleHome(): void
    {
        if ($this->isUserLogged()) {
            // Page contenant la résultat du premier candidat
            $this->navBar->setMenuVisible(true);
            $sidebarElements = [
                ['path' => '/', 'label' => 'Accueil'],
                ['path' => '/entry', 'label' => 'Saisie'],
            ];
            $this->templateRenderer->setSidebarContent($sidebarElements);
            $this->templateRenderer->setNavbarContent($this->navBar->render());
            $this->templateRenderer->setBodyContent($this->electionResult());
            echo $this->templateRenderer->render("Home");
            exit();
        } else {
            // Page contenant la résultat du premier candidat
            $this->templateRenderer->setNavbarContent($this->navBar->render());
            $this->templateRenderer->setBodyContent($this->electionResult());
            echo $this->templateRenderer->render("Home");
            exit();
        }
    }

    private function electionResult()
    {
        return <<<HTML
        <div class="d-flex w-100 justify-content-center align-items-center">
            <p>
                test
            </p>
        </div>
        HTML;
    }

    public function loginPage(): void
    {
        if ($this->isUserLogged()) {
            header("Location: /");
            exit();
        }
        $this->templateRenderer->setBodyContent($this->login->__invoke());
        echo $this->templateRenderer->render("Login");
        exit();
    }

    public function handleLogin(): void
    {
        if (isset($_POST)) {
            if (isset($_POST["email"]) && isset($_POST["password"])) {

                $this->userLogged = $this->userModel->getUserByEmail($_POST);

                if (count($this->userLogged) > 0) {
                    $_SESSION["user"] = $this->userLogged;
                    header("Location: /");
                    exit;
                } else {
                    // Utilisateur non autorisé (mot de passe incorrect)
                    header("HTTP/1.1 401");
                    $this->loginPage();
                    exit;
                }
            } else {
                // Requête incorrecte (paramètres manquants)
                header("HTTP/1.1 400");
                $this->loginPage();
                exit;
            }
        }
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: /");
        exit();
    }
}
