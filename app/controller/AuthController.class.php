<?php

namespace controller;

use model\UserModel;
use views\Login;

class AuthController
{

    private $loginPage;
    private $loggedUser;
    private $userModel;

    private function setUserModel(UserModel $userModel): void
    {
        $this->userModel = $userModel;
    }

    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }

    public function __construct()
    {
        $this->setLoginPage(new Login());
        $this->setUserModel(new UserModel());
        // $this->userModel = new UserModel();
    }

    public function setLoggedUser($loggedUser): void
    {
        $this->loggedUser = $loggedUser;
    }

    public function getLoggeduser(): array
    {
        return [];
    }

    public function setLoginPage(Login $loginPage): void
    {
        $this->loginPage = $loginPage;
    }

    public function getLoginPage(): Login
    {
        return $this->loginPage;
    }

    public function renderLoginPage()
    {
        echo $this->loginPage->render();
    }

    public function handleLogin(): void
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            // get user from db
            $this->loggedUser = $this->userModel->getUserByEmail($_POST);

            if (!empty($this->loggedUser)) {
                // créer un session pour l'utilisateur connecté
                session_start();
                $_SESSION["user"] = $this->loggedUser;
                header("Location: /");
                exit();
            } else {
                echo "error";
            }
        }
    }

    public function handleLogout(): void
    {
        header("Location: /");
        session_start();
        session_destroy();
        exit();
    }


    public function isUserLogged(): bool
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }
}