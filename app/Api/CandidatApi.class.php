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

    public function handleCreate() : void
    {
        if($this->verifySession()){
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
        }{
            $this->sendResponse(403,["error"=>"Vous n'êtes pas autorisé à faire cette action."]);
        }
    }

    public function handleEdit() : void {
        
    }

    private function verifySession(): bool {
        if (isset($_SESSION["user"]) && isset($_SESSION["user"][0]) && ($_SESSION["user"][0]["role"] == "admin" || $_SESSION["user"][0]["role"] == "operator")) {
            return true;
        }
        return false;
    }
    
}
