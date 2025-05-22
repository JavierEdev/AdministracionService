<?php
include_once 'models/Reserva.php';

class ReservasController
{
    private $db;
    private $reserva;

    public function __construct($db)
    {
        $this->db = $db;
        $this->reserva = new Reserva($db);
    }

    public function getAllReservas()
    {
        $stmt = $this->reserva->read_all_reservas();
        $reservasResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::send(200, $reservasResponse);
    }

    public function getReservaById($data)
    {
        if (!isset($data['id_reserva']) || !is_numeric($data['id_reserva'])) {
            Response::send(400, ['message' => 'ID de reserva inválido']);
            return;
        }
        $stmt = $this->reserva->read_single_reserva($data['id_reserva']);
        $reservaResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($reservaResponse)) {
            Response::send(404, ['message' => 'Reserva no encontrada']);
        } else {
            Response::send(200, $reservaResponse);
        }
    }
}
?>