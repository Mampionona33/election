<?php
// Gestion des erreurs probables
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------


$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

switch ($uri) {
    case '/':
        if (isset($_GET)) {
            http_response_code(200);
            $content = "Hello word";
        }
        break;

    default:
        http_response_code(404);
        include_once "views/page_not_found.php";
        break;
}

require_once "template/template.php";
