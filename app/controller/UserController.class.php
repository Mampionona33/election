<?php

namespace controller;

use lib\CustomCard;
use lib\CustomTable;
use model\CandidatModel;
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
    private $adminSideBarItem;
    private $candidatModel;
    private $customCard;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->templateRenderer = new TemplateRenderer();
        $this->navBar = new Navbar();
        $this->login = new Login();
        $this->candidatModel = new CandidatModel();
        $this->adminSideBarItem = [
            ['path' => '/', 'label' => 'Accueil'],
            ['path' => '/entry', 'label' => 'Saisie'],
        ];
        $this->customCard = new CustomCard();
    }

    private function isUserLogged(): bool
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }

    private function setAdminSidebarContent(): void
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

    private function redirectIfUserNotLogged(): void
    {
        if (!$this->isUserLogged() && $_SERVER['REQUEST_URI'] !== '/') {
            header("Location: /login");
            exit();
        }
    }

    public function handleHome(): void
    {
        $this->redirectIfUserNotLogged();
        $this->setAdminSidebarContent();
        $this->templateRenderer->setBodyContent($this->electionResult());
        echo $this->templateRenderer->render("Home");
        exit();
    }

    private function electionResult()
    {
        $firstCandidatResult = $this->candidatModel->getFirstCandidatResult();
        $candidatName = $firstCandidatResult["name"];
        $candidatResult = $firstCandidatResult["result"];
        var_dump($firstCandidatResult);

        $this->customCard->setTitle("Résultat pour le candidat $candidatName");
        $result = "";

        if ($candidatResult >= 50) {
            $result .= "$candidatName est élu au premier tour";
        }

        // $this->customCard->setContent();
        if ($candidatResult)
            $customCard = $this->customCard->__invoke();
        return <<<HTML
        <div class="d-flex w-100 justify-content-center align-items-center">
            <p>
                $customCard
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
                    exit();
                } else {
                    // Utilisateur non autorisé (mot de passe incorrect)
                    header("HTTP/1.1 401");
                    $this->loginPage();
                    exit();
                }
            } else {
                // Requête incorrecte (paramètres manquants)
                header("HTTP/1.1 400");
                $this->loginPage();
                exit;
            }
        }
    }

    public function handleEntry(): void
    {
        $this->redirectIfUserNotLogged();
        $this->setAdminSidebarContent();
        $this->templateRenderer->setBodyContent($this->pageEntryContent());
        echo $this->templateRenderer->render("Entry");
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: /");
        exit();
    }

    private function pageEntryContent(): string
    {
        $tableHeader = ["id_candidat", "Nom", "Nombre de voix", "Pourcentage"];
        $listCandidat = $this->candidatModel->getCandidats();
        $tableCandidat = new CustomTable("candidat", $tableHeader, $listCandidat);
        $tableCandidat->setBtnEditeState(true);
        $tableCandidat->setBtnDeleteState(true);
        $tableCandidat->setAddBtnVisible(true);

        $table = $tableCandidat->renderTable();

        return <<<HTML
        <div class="d-flex align-items-center w-100 justify-content-center" >
            $table
        </div>
        HTML;
    }
}
