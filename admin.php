<?php
include_once 'config/db.php';
include_once 'helpers/Response.php';
include_once 'controllers/LugaresController.php';
include_once 'controllers/RutasController.php';
include_once 'controllers/BusesController.php';
include_once 'controllers/ReservasController.php';
include_once 'controllers/HorariosController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim(str_replace('/AdministracionService/admin.php', '', $uri), '/'));

$db = (new DB())->getConnection();

switch ($uri[0]) {
    case 'lugares':
        $lugaresController = new LugaresController($db);

        if ($method === 'POST' && !isset($uri[1])) {
            $lugaresController->getAllLugares();
        }

        if ($method === 'POST' && $uri[1] === 'idLugar') {
            $data = json_decode(file_get_contents("php://input"), true);
            $lugaresController->getLugarById($data);
        }

        if ($method === 'POST' && $uri[1] === 'insertLugar') {
            $data = json_decode(file_get_contents("php://input"), true);
            $lugaresController->insertLugar($data);
        }

        if ($method === 'PUT' && $uri[1] === 'updateLugar') {
            $data = json_decode(file_get_contents("php://input"), true);
            $lugaresController->updateLugar($data['id_lugar'], $data);
        }

        if ($method === 'DELETE' && $uri[1] === 'deleteLugar') {
            $data = json_decode(file_get_contents("php://input"), true);
            $lugaresController->deleteLugar($data);
        }
        break;

    case 'rutas':
        $rutasController = new RutasController($db);

        if ($method === 'POST' && !isset($uri[1])) {
            $rutasController->getAllRutas();
        }

        if ($method === 'POST' && $uri[1] === 'idRuta') {
            $data = json_decode(file_get_contents("php://input"), true);
            $rutasController->getRutaById($data);
        }

        if ($method === 'POST' && $uri[1] === 'insertRuta') {
            $data = json_decode(file_get_contents("php://input"), true);
            $rutasController->insertRuta($data);
        }

        if ($method === 'PUT' && $uri[1] === 'updateRuta') {
            $data = json_decode(file_get_contents("php://input"), true);
            $rutasController->updateRuta($data['id_ruta'], $data);
        }

        if ($method === 'DELETE' && $uri[1] === 'deleteRuta') {
            $data = json_decode(file_get_contents("php://input"), true);
            $rutasController->deleteRuta($data);
        }
        break;

    case 'buses':
        $busesController = new BusesController($db);

        if ($method === 'POST' && !isset($uri[1])) {
            $busesController->getAllBuses();
        }

        if ($method === 'POST' && $uri[1] === 'idBus') {
            $data = json_decode(file_get_contents("php://input"), true);
            $busesController->getBusById($data);
        }

        if ($method === 'POST' && $uri[1] === 'insertBus') {
            $data = json_decode(file_get_contents("php://input"), true);
            $busesController->insertBus($data);
        }

        if ($method === 'PUT' && $uri[1] === 'updateBus') {
            $data = json_decode(file_get_contents("php://input"), true);
            $busesController->updateBus($data['id_bus'], $data);
        }

        if ($method === 'DELETE' && $uri[1] === 'deleteBus') {
            $data = json_decode(file_get_contents("php://input"), true);
            $busesController->deleteBus($data);
        }
        break;

    case 'reservas':
        $reservasController = new ReservasController($db);

        if ($method === 'POST' && !isset($uri[1])) {
            $reservasController->getAllReservas();
        }

        if ($method === 'POST' && $uri[1] === 'idReserva') {
            $data = json_decode(file_get_contents("php://input"), true);
            $reservasController->getReservaById($data);
        }
        break;

    case 'horarios':
        $horariosController = new HorariosController($db);

        if ($method === 'POST' && $uri[1] === 'idRuta') {
            $data = json_decode(file_get_contents("php://input"), true);
            $horariosController->getHorariosByRuta($data);
        }

        if ($method === 'POST' && $uri[1] === 'idHorario') {
            $data = json_decode(file_get_contents("php://input"), true);
            $horariosController->getHorarioById($data);
        }

        if ($method === 'POST' && $uri[1] === 'insertHorario') {
            $data = json_decode(file_get_contents("php://input"), true);
            $horariosController->insertHorario($data);
        }

        if ($method === 'PUT' && $uri[1] === 'updateHorario') {
            $data = json_decode(file_get_contents("php://input"), true);
            $horariosController->updateHorario($data);
        }

        if ($method === 'DELETE' && $uri[1] === 'deleteHorario') {
            $data = json_decode(file_get_contents("php://input"), true);
            $horariosController->deleteHorario($data);
        }
        break;

    default:
        Response::send(404, ['message' => 'Not found']);
        break;
}
?>