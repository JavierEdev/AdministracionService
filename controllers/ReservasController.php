<?php
include_once 'dao/ReservaDAO.php';

class ReservasController
{
    private $db;
    private $reservaDAO;

    public function __construct($db)
    {
        $this->db = $db;
        $this->reservaDAO = new ReservaDAO($db);
    }

    public function getAllReservas()
    {
        $stmt = $this->reservaDAO->read_all_reservas();
        $reservasResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::send(200, $reservasResponse);
    }

    public function getReservaById($data)
    {
        if (!isset($data['id_reserva']) || !is_numeric($data['id_reserva'])) {
            Response::send(400, ['message' => 'ID de reserva inválido']);
            return;
        }
        $stmt = $this->reservaDAO->read_single_reserva($data['id_reserva']);
        $reservaResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($reservaResponse)) {
            Response::send(404, ['message' => 'Reserva no encontrada']);
        } else {
            Response::send(200, $reservaResponse);
        }
    }
}