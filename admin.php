<?php
include_once 'config/db.php';
include_once 'helpers/Response.php';
include_once 'factories/ControllerFactory.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim(str_replace('/AdministracionService/admin.php', '', $uri), '/'));

$db = (new DB())->getConnection();

if (empty($uri[0])) {
    Response::send(404, ['message' => 'Not found']);
    exit;
}

try {
    $controller = ControllerFactory::createController($uri[0], $db);
} catch (Exception $e) {
    Response::send(404, ['message' => 'Not found']);
    exit;
}

$action = isset($uri[1]) ? $uri[1] : null;
$data = $method === 'GET' ? $_GET : json_decode(file_get_contents("php://input"), true);

switch ($uri[0]) {
    case 'lugares':
        if ($method === 'POST' && !$action) {
            $controller->getAllLugares();
        } elseif ($method === 'POST' && $action === 'idLugar') {
            $controller->getLugarById($data);
        } elseif ($method === 'POST' && $action === 'insertLugar') {
            $controller->insertLugar($data);
        } elseif ($method === 'PUT' && $action === 'updateLugar') {
            $controller->updateLugar($data['id_lugar'], $data);
        } elseif ($method === 'DELETE' && $action === 'deleteLugar') {
            $controller->deleteLugar($data);
        } else {
            Response::send(404, ['message' => 'Not found']);
        }
        break;

    case 'rutas':
        if ($method === 'POST' && !$action) {
            $controller->getAllRutas();
        } elseif ($method === 'POST' && $action === 'idRuta') {
            $controller->getRutaById($data);
        } elseif ($method === 'POST' && $action === 'insertRuta') {
            $controller->insertRuta($data);
        } elseif ($method === 'PUT' && $action === 'updateRuta') {
            $controller->updateRuta($data['id_ruta'], $data);
        } elseif ($method === 'DELETE' && $action === 'deleteRuta') {
            $controller->deleteRuta($data);
        } else {
            Response::send(404, ['message' => 'Not found']);
        }
        break;

    case 'buses':
        if ($method === 'POST' && !$action) {
            $controller->getAllBuses();
        } elseif ($method === 'POST' && $action === 'idBus') {
            $controller->getBusById($data);
        } elseif ($method === 'POST' && $action === 'insertBus') {
            $controller->insertBus($data);
        } elseif ($method === 'PUT' && $action === 'updateBus') {
            $controller->updateBus($data['id_bus'], $data);
        } elseif ($method === 'DELETE' && $action === 'deleteBus') {
            $controller->deleteBus($data);
        } else {
            Response::send(404, ['message' => 'Not found']);
        }
        break;

    case 'reservas':
        if ($method === 'POST' && !$action) {
            $controller->getAllReservas();
        } elseif ($method === 'POST' && $action === 'idReserva') {
            $controller->getReservaById($data);
        } else {
            Response::send(404, ['message' => 'Not found']);
        }
        break;

    case 'horarios':
        if ($method === 'POST' && $action === 'idRuta') {
            $controller->getHorariosByRuta($data);
        } elseif ($method === 'POST' && $action === 'idHorario') {
            $controller->getHorarioById($data);
        } elseif ($method === 'POST' && $action === 'insertHorario') {
            $controller->insertHorario($data);
        } elseif ($method === 'PUT' && $action === 'updateHorario') {
            $controller->updateHorario($data);
        } elseif ($method === 'DELETE' && $action === 'deleteHorario') {
            $controller->deleteHorario($data);
        } else {
            Response::send(404, ['message' => 'Not found']);
        }
        break;

    default:
        Response::send(404, ['message' => 'Not found']);
        break;
}