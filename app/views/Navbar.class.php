<?php

namespace views;

class Navbar
{
    private $options;
    private $title;
    private $menuVisible = false;

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
        return '<button class="btn btn-primary d-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    <span class="material-icons">menu</span>
                </button>';
    }

    public function setMenuVisible(bool $menuVisible): void
    {
        $this->menuVisible = $menuVisible;
    }

    public function render(): string
    {
        $logButton = $this->logButton();
        $title = $this->renderTitle();
        $menuButton = $this->menuVisible ?  $this->renderMenuButton() : null;

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
