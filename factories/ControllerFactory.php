<?php
include_once __DIR__ . '/../controllers/LugaresController.php';
include_once __DIR__ . '/../controllers/RutasController.php';
include_once __DIR__ . '/../controllers/BusesController.php';
include_once __DIR__ . '/../controllers/ReservasController.php';
include_once __DIR__ . '/../controllers/HorariosController.php';

class ControllerFactory {
    public static function createController($resource, $db) {
        switch (strtolower($resource)) {
            case 'lugares':
                return new LugaresController($db);
            case 'rutas':
                return new RutasController($db);
            case 'buses':
                return new BusesController($db);
            case 'reservas':
                return new ReservasController($db);
            case 'horarios':
                return new HorariosController($db);
            default:
                throw new Exception("Controlador no encontrado para el recurso: $resource");
        }
    }
}