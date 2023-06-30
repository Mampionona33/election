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

    public function handleCreate(): void
    {
        if ($this->verifySession()) {
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
                } else {
                    $this->sendResponse(400, ["error" => "Missing name or nbVoix parameter"]);
                }
            }
        } else {
            $this->sendResponse(403, ["error" => "Vous n'êtes pas autorisé à faire cette action."]);
        }
    }

    public function handleEdit(): void
    {
        if ($this->verifySession()) {
            if ($_SERVER["REQUEST_METHOD"] === "PUT") {
                // Get the raw input data
                $inputData = file_get_contents("php://input");

                // Decode the JSON data into an associative array
                $formData = json_decode($inputData, true);
                if (isset($formData["id_candidat"])) {
                    $id_candidat = $formData["id_candidat"];
                    $candidatToModified = $this->getCandidat($id_candidat);

                    if (!empty($candidatToModified)) {
                        $updateCandidat = $this->candidatModel->update($formData);
                        if ($updateCandidat) {
                            $this->sendResponse(201, ["Information" => "Le candidat a été modifié avec succés."]);
                        } else {
                            $this->sendResponse(403, ["error" => "Erreur lors de la modification du candidat"]);
                        }
                    }
                }

                // Access the PUT data
                // var_dump($formData);
            }
        } else {
            $this->sendResponse(403, ["error" => "Vous n'êtes pas autorisé à faire cette action."]);
        }
    }

    private function getCandidat($id): array
    {
        $candidat = $this->candidatModel->getCandidat($id);
        if (!empty($candidat)) {
            return $candidat;
        }
        return [];
    }

    public function handleGetCandidats(): void
    {
        if ($this->verifySession()) {
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                if (isset($_GET["id_candidat"])) {
                    $id_candidat = $_GET["id_candidat"];
                    $candidat = $this->candidatModel->getCandidat($id_candidat);
                    if (!empty($candidat)) {
                        $this->sendResponse(200, ["data" => $candidat]);
                    } else {
                        $this->sendResponse(404, ["error" => "Candidat not found"]);
                    }
                } else {
                    $this->sendResponse(400, ["error" => "Missing id_candidat parameter"]);
                }
            }
        } else {
            $this->sendResponse(403, ["error" => "Vous n'êtes pas autorisé à faire cette action."]);
        }
    }

    private function verifySession(): bool
    {
        session_start();
        if (isset($_SESSION["user"]) && isset($_SESSION["user"][0]) && ($_SESSION["user"][0]["role"] == "admin" || $_SESSION["user"][0]["role"] == "operator")) {
            return true;
        }
        session_destroy();
        return false;
    }
}
