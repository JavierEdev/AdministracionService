<?php
include_once __DIR__ . '/../dao/interfaces/InterfaceReservaDAO.php';

class ReservaDAO implements InterfaceReservaDAO {
    private $conn;
    private $table = 'reserva';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_all_reservas() {
        $query = "SELECT 
                     r.id_reserva,
                     r.correo_cliente,
                     CONCAT(lo.nombre, ' - ', ld.nombre) AS ruta,
                     CONCAT(h.hora_salida, ' - ', h.hora_llegada) AS horario,
                     r.cantidad_asientos,
                     r.codigo_boleto,
                     r.estado,
                     r.fecha_reserva
                  FROM " . $this->table . " r
                  INNER JOIN horario h ON r.id_horario = h.id_horario
                  INNER JOIN ruta rt ON h.id_ruta = rt.id_ruta
                  INNER JOIN lugar lo ON rt.id_origen = lo.id_lugar
                  INNER JOIN lugar ld ON rt.id_destino = ld.id_lugar";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single_reserva($id_reserva) {
        $query = "SELECT 
                     r.id_reserva,
                     r.correo_cliente,
                     CONCAT(lo.nombre, ' - ', ld.nombre) AS ruta,
                     CONCAT(h.hora_salida, ' - ', h.hora_llegada) AS horario,
                     r.cantidad_asientos,
                     r.codigo_boleto,
                     r.estado,
                     r.fecha_reserva
                  FROM " . $this->table . " r
                  INNER JOIN horario h ON r.id_horario = h.id_horario
                  INNER JOIN ruta rt ON h.id_ruta = rt.id_ruta
                  INNER JOIN lugar lo ON rt.id_origen = lo.id_lugar
                  INNER JOIN lugar ld ON rt.id_destino = ld.id_lugar
                  WHERE r.id_reserva = :id_reserva LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}