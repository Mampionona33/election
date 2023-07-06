<?php

namespace views;

use controller\Authorization;

class Navbar
{
    private $options;
    private $title;
    private $menuVisible = false;
    private $authorization;

    public function setAuthorization(Authorization $authorization): void
    {
        $this->authorization = $authorization;
    }

    public function getAuthorization(): Authorization
    {
        return $this->authorization;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private function renderTitle()
    {
        if ($this->title) {
            return '<div class="text-light fs-4">' . $this->title . '</div>';
        }
    }

    private function logButton(): string
    {
        if (!isset($_SESSION["user"])) {
            return '<a class="navbar-brand" href="/login">login</a>';
        }
        return '<a class="navbar-brand" href="/logout">log out</a>';
    }

    private function renderMenuButton()
    {
        // Vérifiez si l'utilisateur a l'autorisation d'afficher le bouton de menu
        $userIdGroupe = isset($_SESSION["user"]) && isset($_SESSION["user"][0]["id_groupe"]) ? $_SESSION["user"][0]["id_groupe"] : null;
        if ($this->authorization->isAuthorized($userIdGroupe, 'menu_button')) {
            return '<button class="btn btn-primary d-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    <span class="material-icons">menu</span>
                </button>';
        }
    }

    public function setMenuVisible(bool $menuVisible): void
    {
        $this->menuVisible = $menuVisible;
    }

    public function render(): string
    {
        $logButton = $this->logButton();
        $title = $this->renderTitle();
        $menuButton = $this->renderMenuButton();

        return <<<HTML
            <div class="container-fluid">
                <div class="d-flex justify-content-start">
                    $menuButton
                </div>
                <div class="d-flex justify-content-end">
                    $title
                    <div class="collapse navbar-collapse" id="navbarMenu">
                        $logButton
                    </div>
                </div>
            </div>
        HTML;
    }
}
