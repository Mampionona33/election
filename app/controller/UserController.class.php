<?php

namespace controller;

use lib\DataManipulator;
use model\UserModel;

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

    private $users;
    private $userModel;

    public function setUserModel(UserModel $userModel): void
    {
        $this->userModel = $userModel;
    }

    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }

    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    public function getUsers(): array
    {
        return $this->users;
    }


    public function __construct()
    {
        $this->users = $this->userModel->getUsers();
    }
}
