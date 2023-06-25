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

    public function isUserLogged(): bool
    {
        return false;
    }
}
