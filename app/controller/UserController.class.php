<?php

namespace controller;

use model\UserModel;
use views\Login;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function isUserLogged(): bool
    {
        if (isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }

    public function handleHome()
    {
        if ($this->isUserLogged()) {
            echo "Bienvenue, utilisateur connecté !";
        } else {
            // Page contenant la résultat du premier candidat
        }
    }
}
