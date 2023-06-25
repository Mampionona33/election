<?php

namespace controller;

use model\UserModel;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function isUserLogged(): bool
    {
        return false;
    }

    public function handleHome()
    {
        if ($this->isUserLogged()) {
            echo "Bienvenue, utilisateur connecté !";
        } else {
            echo "Veuillez vous connecter.";
        }
    }
}
