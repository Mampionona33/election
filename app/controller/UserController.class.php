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
    private $firstCandidat;
    private $candidatMaxPoint;
    private $firstCandidatName;
    private $firstCandidatPoint;
    private $firstCandidatPercentage;
    private $candidatMaxPointPercentage;
    private $firstCandidatId;
    private $candidatMaxPointId;
    private $candidatMaxName;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->templateRenderer = new TemplateRenderer();
        $this->navBar = new Navbar();
        $this->login = new Login();
        $this->candidatModel = new CandidatModel();
        $this->firstCandidat = $this->candidatModel->getFirstCandidatResult();
        $this->candidatMaxPoint = $this->candidatModel->getCandidatMaxPoint();

        $this->firstCandidatId = count($this->firstCandidat) > 0 ? floatval($this->firstCandidat[0]["id_candidat"]) : null;
        $this->candidatMaxPointId = count($this->candidatMaxPoint) > 0 ? floatval($this->candidatMaxPoint[0]["id_candidat"]) : null;

        $this->firstCandidatPercentage = count($this->firstCandidat) > 0 ? floatval($this->firstCandidat[0]["percentage"]) : null;
        $this->candidatMaxPointPercentage = count($this->candidatMaxPoint) > 0 ? floatval($this->candidatMaxPoint[0]["percentage"]) : null;

        $this->firstCandidatName = count($this->firstCandidat) > 0 ? $this->firstCandidat[0]["name"] : null;
        $this->candidatMaxName = count($this->candidatMaxPoint) > 0 ? $this->candidatMaxPoint[0]["name"] : null;

        $this->adminSideBarItem = [
            ['path' => '/', 'label' => 'Accueil'],
            ['path' => '/entry', 'label' => 'Gestion des candidats'],
        ];
        $this->customCard = new CustomCard();
        $this->customCard->setIcon("how_to_vote");
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
        // if (isset($_SESSION)) {
        //     if ($this->isUserLogged()) {
        //         session_start();
        //         $this->setAdminSidebarContent();
        //     }
        // }
        // $this->navBar->setMenuVisible(true);
        // $this->templateRenderer->setNavbarContent($this->navBar->render());
        // $this->redirectIfUserNotLogged();
        // $this->templateRenderer->setBodyContent($this->electionResult());
        // echo $this->templateRenderer->render("Home");
        // exit();
    }

    private function electionResult()
    {
        $result = "";

        if (isset($this->firstCandidatId) && isset($this->candidatMaxPointId)) {
            $this->customCard->setTitle("Résultat pour le candidat : $this->firstCandidatName");

            if ($this->firstCandidatPercentage > 50) {
                $result .= "$this->firstCandidatName est élu à la première tour avec un suffrage de $this->firstCandidatPercentage %.";
            } elseif ($this->candidatMaxPointPercentage > 50) {
                $result .= "Le candidat $this->firstCandidatName est battu à la première tour avec un suffrage de $this->firstCandidatPercentage %.";
            } elseif ($this->firstCandidatPercentage > 12.5) {
                if ($this->firstCandidatPercentage >= $this->candidatMaxPointPercentage) {
                    $result .= "Le candidat $this->firstCandidatName participe au deuxième tour en ballotage favorable avec un suffrage de $this->firstCandidatPercentage %.";
                } else {
                    $result .= "Le candidat $this->firstCandidatName participe au deuxième tour en ballotage défavorable avec un suffrage de $this->firstCandidatPercentage %.";
                }
            } else {
                $result .= "Le candidat $this->firstCandidatName est battu à la première tour avec un suffrage de $this->firstCandidatPercentage %.";
            }
        }

        $this->customCard->setContent($result);
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
                    session_start();
                    $_SESSION["user"] = $this->userLogged;
                    header("Location: /", true, 302);
                    exit();
                } else {
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
        // $this->redirectIfUserNotLogged();
        $this->setAdminSidebarContent();
        $this->templateRenderer->setBodyContent($this->pageEntryContent());
        echo $this->templateRenderer->render("Entry");
    }

    public function logout(): void
    {
        session_start();
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
