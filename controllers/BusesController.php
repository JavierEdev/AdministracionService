<?php
include_once 'models/Bus.php';

class BusesController
{
    private $db;
    private $bus;

    public function __construct($db)
    {
        $this->db = $db;
        $this->bus = new Bus($db);
    }

    public function getAllBuses()
    {
        $stmt = $this->bus->read_all_buses();
        $busesResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::send(200, $busesResponse);
    }

    public function getBusById($data)
    {
        if (!isset($data['id_bus']) || !is_numeric($data['id_bus'])) {
            Response::send(400, ['message' => 'ID de bus inválido']);
            return;
        }
        $stmt = $this->bus->read_single_bus($data['id_bus']);
        $busResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($busResponse)) {
            Response::send(404, ['message' => 'Bus no encontrado']);
        } else {
            Response::send(200, $busResponse);
        }
    }

    public function insertBus($data)
    {
        if (!isset($data['placa']) || empty(trim($data['placa'])) || !preg_match('/^.{1,20}$/s', $data['placa'])) {
            Response::send(400, ['message' => 'Placa inválida, debe ser no vacía y tener entre 1 y 20 caracteres']);
            return;
        }
        if (!isset($data['capacidad']) || !is_numeric($data['capacidad']) || $data['capacidad'] <= 0) {
            Response::send(400, ['message' => 'Capacidad inválida, debe ser un número positivo']);
            return;
        }
        if (!isset($data['capacidad']) || !is_numeric($data['capacidad']) || $data['capacidad'] > 50 || $data['capacidad'] < 10) {
            Response::send(400, ['message' => 'Capacidad inválida, debe ser un número entre 10 y 50']);
            return;
        }
        
        $data['estado'] = isset($data['estado']) && is_numeric($data['estado']) ? $data['estado'] : 1;
        if ($this->bus->insert_bus($data)) {
            Response::send(200, ['message' => 'Bus insertado']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error al insertar el bus']);
        }
    }

    public function updateBus($id_bus, $data)
    {
        if (!isset($data['placa']) || empty(trim($data['placa'])) || !preg_match('/^.{1,20}$/s', $data['placa'])) {
            Response::send(400, ['message' => 'Placa inválida, debe ser no vacía y tener entre 1 y 20 caracteres']);
            return;
        }
        if (!isset($data['capacidad']) || !is_numeric($data['capacidad']) || $data['capacidad'] <= 0) {
            Response::send(400, ['message' => 'Capacidad inválida, debe ser un número positivo']);
            return;
        }

        $data['estado'] = isset($data['estado']) && is_numeric($data['estado']) ? $data['estado'] : 1;
        if ($this->bus->update_bus($id_bus, $data)) {
            Response::send(200, ['message' => 'Bus actualizado']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error al actualizar el bus']);
        }
    }

    public function deleteBus($data)
    {
        if (!isset($data['id_bus']) || !is_numeric($data['id_bus'])) {
            Response::send(400, ['message' => 'ID de bus inválido']);
            return;
        }
        $result = $this->bus->delete_bus($data);
        if ($result === null) {
            Response::send(404, ['message' => 'Bus no encontrado']);
        } elseif ($result === false) {
            Response::send(400, ['message' => 'No se puede eliminar el bus: debe estar inactivo y no asignado a horarios']);
        } else {
            Response::send(200, ['message' => 'Bus borrado']);
        }
    }
}
?>