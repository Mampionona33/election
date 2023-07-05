<?php

namespace controller;

use lib\CustomCard;
use lib\CustomTable;
use model\CandidatModel;
use model\GroupeModel;
use model\RoleModel;
use model\UserModel;
use template\TemplateRenderer;
use views\Login;
use views\Navbar;

class UserController
{

    /**
     * TODO :
     * - [x] create use case diagram
     * - [x] create class diagram
     * - [x] create classe Authorisation
     * - [x] create RoleModel classe
     * - [x] create GroupeModel classe
     * - [x] create table Role on calling UserController
     * - [x] create table Groupe on calling UserController
     * - [x] create table User on calling UserController
     * - [x] create table Candidat on calling UserController
     * - [x] instanciate new object authorisation from Authorization
     * - [x] test assign roles to groupes. Using the created object authorization
     * - [] clean class CandidatModel
     * - [] create UserApi for handling request from modals
     * - [] create RoleApi for handling request from modals
     * - [] create GroupeApi for handling request form modals
     * - [] Refonte CandidatApi to match the authorization method
     * - [] create visitor home page
     * - [] create manage role page
     * - [] create manage groupe page
     * - [] create manage user page
     * - [] create login page
     * - [] Mis fanotanina mahakasika an'le clean code! ts 
     *      maints mampiasa this fona ve na oe variable temp 
     *      an'le function ary le variabe 
     */

    private $authorization;
    private $userGroupeId;
    private $roleModel;
    private $userModel;
    private $groupeModel;
    private $templateRenderer;
    private $navBar;
    private $authController;

    public function setAuthController(AuthController $authController): void
    {
        $this->authController = $authController;
    }

    public function getController(): AuthController
    {
        return $this->authController;
    }

    public function setNavBar(Navbar $navBar): void
    {
        $this->navBar;
    }

    public function getNavBar(): Navbar
    {
        return $this->navBar;
    }


    public function setTemplateRenderer($templateRenderer): void
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function getTemplateRenderer(): string
    {
        return $this->templateRenderer;
    }

    public function setUserModel(UserModel $userModel): void
    {
        $this->userModel = $userModel;
    }

    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }

    public function setGroupeModel(GroupeModel $groupeModel): void
    {
        $this->groupeModel = $groupeModel;
    }

    public function getGroupeModel(): GroupeModel
    {
        return $this->groupeModel;
    }

    public function setRoleModel(RoleModel $roleModel): void
    {
        $this->roleModel = $roleModel;
    }

    public function getRoleModel(): RoleModel
    {
        return $this->roleModel;
    }

    public function setAuthorization(Authorization $authorization): void
    {
        $this->authorization = $authorization;
    }
    public function getAuthorization(): Authorization
    {
        return $this->authorization;
    }

    public function setUserGroupeId(int $userGroupeId): void
    {
        $this->userGroupeId = $userGroupeId;
    }

    public function getUserGroupId(): int
    {
        return $this->userGroupeId;
    }

    public function __construct()
    {
        $this->setRoleModel(new RoleModel());
        $this->setGroupeModel(new GroupeModel());
        $this->setUserModel(new UserModel());
        $this->setTemplateRenderer(new TemplateRenderer());
        $this->navBar = new Navbar();
        $this->setAuthorization(new Authorization());
        $this->setAuthController(new AuthController());
        // Setup authorization
        $this->navBar->setAuthorization($this->authorization);
        $this->authorization->addGroupeRoles(1, "menu_button");
    }

    public function handleHome()
    {
        session_start();
        if ($this->authController->isUserLogged()) {
            $this->templateRenderer->setNavbarContent($this->navBar->render());
            echo $this->templateRenderer->render();
        }
        $this->templateRenderer->setNavbarContent($this->navBar->render());
        echo $this->templateRenderer->render();
        if (empty($_SESSION["user"])) {
            session_destroy();
        }
        exit();
    }



    // private $userModel;
    // private $templateRenderer;
    // private $navBar;
    // private $userLogged;
    // private $login;
    // private $adminSideBarItem;
    // private $candidatModel;
    // private $customCard;
    // private $firstCandidat;
    // private $candidatMaxPoint;
    // private $firstCandidatName;
    // private $firstCandidatPoint;
    // private $firstCandidatPercentage;
    // private $candidatMaxPointPercentage;
    // private $firstCandidatId;
    // private $candidatMaxPointId;
    // private $candidatMaxName;

    // public function __construct()
    // {
    //     $this->userModel = new UserModel();
    //     $this->templateRenderer = new TemplateRenderer();
    //     $this->navBar = new Navbar();
    //     $this->login = new Login();
    //     $this->candidatModel = new CandidatModel();
    //     $this->firstCandidat = $this->candidatModel->getFirstCandidatResult();
    //     $this->candidatMaxPoint = $this->candidatModel->getCandidatMaxPoint();

    //     $this->firstCandidatId = count($this->firstCandidat) > 0 ? floatval($this->firstCandidat[0]["id_candidat"]) : null;
    //     $this->candidatMaxPointId = count($this->candidatMaxPoint) > 0 ? floatval($this->candidatMaxPoint[0]["id_candidat"]) : null;

    //     $this->firstCandidatPercentage = count($this->firstCandidat) > 0 ? floatval($this->firstCandidat[0]["percentage"]) : null;
    //     $this->candidatMaxPointPercentage = count($this->candidatMaxPoint) > 0 ? floatval($this->candidatMaxPoint[0]["percentage"]) : null;

    //     $this->firstCandidatName = count($this->firstCandidat) > 0 ? $this->firstCandidat[0]["name"] : null;
    //     $this->candidatMaxName = count($this->candidatMaxPoint) > 0 ? $this->candidatMaxPoint[0]["name"] : null;

    //     $this->adminSideBarItem = [
    //         ['path' => '/admin', 'label' => 'Accueil'],
    //         ['path' => '/entry', 'label' => 'Gestion des candidats'],
    //         ['path' => '/users', 'label' => 'Gestion des utilisateurs'],
    //     ];
    //     $this->customCard = new CustomCard();
    //     $this->customCard->setIcon("how_to_vote");
    // }

    // private function isUserLogged(): bool
    // {
    //     return isset($_SESSION["user"]);
    // }

    // private function generateNavbar(): void
    // {
    //     if ($this->isUserLogged()) {
    //         $this->navBar->setMenuVisible(true);
    //         $this->templateRenderer->setSidebarContent($this->adminSideBarItem);
    //     } else {
    //         $this->navBar->setMenuVisible(false);
    //         $this->templateRenderer->setSidebarContent([]);
    //     }
    //     $this->templateRenderer->setNavbarContent($this->navBar->render());
    // }

    // private function redirectToLoginPage(): void
    // {
    //     header("Location: /login");
    //     session_destroy();
    //     exit();
    // }

    // private function redirectToAdminHomePage(): void
    // {
    //     header("Location: /admin");
    //     exit();
    // }

    // private function redirectToVisitorHomePage(): void
    // {
    //     header("Location: /");
    //     exit();
    // }

    // public function adminHomePage(): void
    // {
    //     session_start();
    //     if (!$this->isUserLogged()) {
    //         $this->redirectToLoginPage();
    //     } else {
    //         $this->generateNavbar();
    //         $this->templateRenderer->setBodyContent($this->electionResult());
    //         echo $this->templateRenderer->render("Home");
    //         exit();
    //     }
    // }

    // public function handleHome(): void
    // {
    //     session_start();
    //     if (!empty($_SESSION) && $_SERVER['REQUEST_URI'] == '/') {
    //         $this->redirectToAdminHomePage();
    //     }
    //     $this->templateRenderer->setNavbarContent($this->navBar->render());
    //     $this->templateRenderer->setBodyContent($this->electionResult());
    //     echo $this->templateRenderer->render("Home");
    //     session_destroy();
    //     exit();
    // }

    // private function electionResult()
    // {
    //     $result = "";

    //     if (isset($this->firstCandidatId) && isset($this->candidatMaxPointId)) {
    //         $this->customCard->setTitle("Résultat pour le candidat : $this->firstCandidatName");

    //         if ($this->firstCandidatPercentage > 50) {
    //             $result .= "$this->firstCandidatName est élu à la première tour avec un suffrage de $this->firstCandidatPercentage %.";
    //         } elseif ($this->candidatMaxPointPercentage > 50) {
    //             $result .= "Le candidat $this->firstCandidatName est battu à la première tour avec un suffrage de $this->firstCandidatPercentage %.";
    //         } elseif ($this->firstCandidatPercentage > 12.5) {
    //             if ($this->firstCandidatPercentage >= $this->candidatMaxPointPercentage) {
    //                 $result .= "Le candidat $this->firstCandidatName participe au deuxième tour en ballotage favorable avec un suffrage de $this->firstCandidatPercentage %.";
    //             } else {
    //                 $result .= "Le candidat $this->firstCandidatName participe au deuxième tour en ballotage défavorable avec un suffrage de $this->firstCandidatPercentage %.";
    //             }
    //         } else {
    //             $result .= "Le candidat $this->firstCandidatName est battu à la première tour avec un suffrage de $this->firstCandidatPercentage %.";
    //         }
    //     }

    //     $this->customCard->setContent($result);
    //     $customCard = $this->customCard->__invoke();

    //     return <<<HTML
    //         <div class="d-flex w-100 justify-content-center align-items-center">
    //             <p>
    //                 $customCard
    //             </p>
    //         </div>
    //     HTML;
    // }

    // public function loginPage(): void
    // {
    //     $this->templateRenderer->setBodyContent($this->login->__invoke());
    //     echo $this->templateRenderer->render("Login");
    //     exit();
    // }

    // public function handleLogin(): void
    // {
    //     if (isset($_POST)) {
    //         if (isset($_POST["email"]) && isset($_POST["password"])) {
    //             $this->userLogged = $this->userModel->getUserByEmail($_POST);

    //             if (count($this->userLogged) > 0) {
    //                 session_start();
    //                 $_SESSION["user"] = $this->userLogged;
    //                 $this->redirectToAdminHomePage();
    //             } else {
    //                 header("HTTP/1.1 401");
    //                 $this->loginPage();
    //                 exit();
    //             }
    //         } else {
    //             // Requête incorrecte (paramètres manquants)
    //             header("HTTP/1.1 400");
    //             $this->loginPage();
    //             exit();
    //         }
    //     }
    // }

    // public function handleEntry(): void
    // {
    //     session_start();
    //     if (empty($_SESSION)) {
    //         $this->redirectToLoginPage();
    //     }
    //     $this->generateNavbar();
    //     $this->templateRenderer->setBodyContent($this->pageEntryContent());
    //     echo $this->templateRenderer->render("Entry");
    // }

    // public function logout(): void
    // {
    //     session_start();
    //     session_destroy();
    //     $this->redirectToVisitorHomePage();
    // }

    // private function pageEntryContent(): string
    // {
    //     $tableHeader = ["id_candidat", "Nom", "Nombre de voix", "Pourcentage"];
    //     $listCandidat = $this->candidatModel->getCandidats();
    //     $tableCandidat = new CustomTable("candidat", $tableHeader, $listCandidat);
    //     $tableCandidat->setBtnEditeState(true);
    //     $tableCandidat->setBtnDeleteState(true);
    //     $tableCandidat->setAddBtnVisible(true);

    //     $table = $tableCandidat->renderTable();

    //     return <<<HTML
    //     <div class="d-flex align-items-center w-100 justify-content-center" >
    //         $table
    //     </div>
    //     HTML;
    // }
}
