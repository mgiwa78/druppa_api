<?php
require "bootstrap.php";
require "controller/UserController.php";
require "controller/SignUpController.php";
require "controller/LoginController.php";


use druppaApi\Controller\UserController;
use druppaApi\Controller\SignUpController;
use druppaApi\Controller\LoginController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ($uri[3] === 'users') {
    if ($uri[4] === 'editProfile') {
        $userId = null;
        if (isset($uri[5])) {
            $userId = (int) $uri[5];
        }
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // pass the request method and user ID to the PersonController and process the HTTP request:
        $controller = new UserController($dbConnection, $requestMethod, $userId);
        $controller->processRequest();
    }
} elseif ($uri[3] === 'signup') {
    $userId = null;
    if (isset($uri[2])) {
        $userId = (int) $uri[2];
    }
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new SignUpController($dbConnection, $requestMethod);
    $controller->processRequest();
} elseif ($uri[3] === 'login') {
    $userId = null;
    if (isset($uri[2])) {
        $userId = (int) $uri[2];
    }
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new LoginController($dbConnection, $requestMethod);
    $controller->processRequest();
} else {
    header("HTTP/1.1 404 Not Found");
}

exit();
// the user id is, of course, optional and must be a number:
