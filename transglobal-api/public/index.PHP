<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Cliente;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header("Content-Type: application/json");

// En memoria (array para clientes)
static $clientes = [];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// GET /health
if ($path === '/health' && $method === 'GET') {
    echo json_encode([
        "status" => "ok",
        "app" => $_ENV['APP_NAME'] ?? 'App'
    ]);
    exit;
}

// POST /clientes
if ($path === '/clientes' && $method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['nombre']) || !isset($input['correo'])) {
        http_response_code(400);
        echo json_encode(["error" => "Faltan campos requeridos"]);
        exit;
    }

    $id = uniqid();
    $cliente = new Cliente($id, $input['nombre'], $input['correo']);
    $clientes[] = $cliente;

    echo json_encode($cliente);
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Ruta no encontrada"]);
