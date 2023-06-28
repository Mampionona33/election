<?php

namespace controller;

use model\CandidatModel;

class CandidatController
{
    private $candidatModel;
    public function __construct()
    {
        $this->candidatModel = new CandidatModel;
    }

    public function handleCreate()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Récupérer les données du formulaire ici
            $name = $_POST["name"];
            $nbVoix = $_POST["nbVoix"];

            if ($name && $nbVoix) {
                echo "ok";
            }
        }
    }
}
