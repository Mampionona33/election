<?php

namespace Api;

use Api\Api;
use model\CandidatModel;

class CandidatApi extends Api
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
            $requestData = json_decode(file_get_contents('php://input'), true);

            $name = $requestData["name"];
            $nbVoix = $requestData["nbVoix"];

            if ($name && $nbVoix) {
                $createCandidat = $this->candidatModel->createCandidat($requestData);
                if ($createCandidat) {
                    $this->sendResponse(200, ["message" => "Candidat Create successfully"]);
                } else {
                    $this->sendResponse(500, ["error" => "Error when trying to create candidat"]);
                }
            }
        }
    }
}
