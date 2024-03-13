<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Controllers\VotacaoController;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Max-Age: 3600");

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    exit();
}

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$url = $_ENV['BASE_URL'];

$routes = [
    "$url/votacao" => ['POST' => ['controller' => VotacaoController::class, 'method' => 'criarVotacao']],
];

$requestedRoute = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$requestedRoute][$method])) {
    $routeInfo = $routes[$requestedRoute][$method];
    $controller = new $routeInfo['controller']();
    $method = $routeInfo['method'];
    $controller->$method();
} else {
    http_response_code(404);
    echo json_encode([
        'error_message' => 'Rota não encontrada'
    ]);
}