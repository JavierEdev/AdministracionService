<?php
class Horario
{
    private $conn;
    private $table = 'horario';

    public $id_horario;
    public $id_ruta;
    public $id_bus;
    public $hora_salida;
    public $hora_llegada;
    public $estado;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_by_ruta($id_ruta)
    {
        $query = "SELECT 
                     h.id_horario,
                     CONCAT(lo.nombre, ' - ', ld.nombre) AS ruta,
                     b.placa AS bus_placa,
                     h.hora_salida,
                     h.hora_llegada,
                     h.estado
                  FROM " . $this->table . " h
                  INNER JOIN ruta r ON h.id_ruta = r.id_ruta
                  INNER JOIN lugar lo ON r.id_origen = lo.id_lugar
                  INNER JOIN lugar ld ON r.id_destino = ld.id_lugar
                  INNER JOIN bus b ON h.id_bus = b.id_bus
                  WHERE h.id_ruta = :id_ruta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $id_ruta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

public function read_single_horario($id_horario)
    {
        $query = "SELECT 
                     h.id_horario,
                     h.id_ruta,
                     CONCAT(lo.nombre, ' - ', ld.nombre) AS ruta,
                     b.placa AS bus_placa,
                     h.hora_salida,
                     h.hora_llegada,
                     h.estado
                  FROM " . $this->table . " h
                  INNER JOIN ruta r ON h.id_ruta = r.id_ruta
                  INNER JOIN lugar lo ON r.id_origen = lo.id_lugar
                  INNER JOIN lugar ld ON r.id_destino = ld.id_lugar
                  INNER JOIN bus b ON h.id_bus = b.id_bus
                  WHERE h.id_horario = :id_horario LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function insert_horario($data)
    {
        $query = "SELECT COUNT(*) FROM ruta WHERE id_ruta = :id_ruta AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta'], PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return false;
        }

        // Validar bus activo
        $query = "SELECT COUNT(*) FROM bus WHERE id_bus = :id_bus AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $data['id_bus'], PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return false;
        }

        // Validar disponibilidad del bus
        if (!$this->check_bus_availability($data['id_bus'], $data['hora_salida'], $data['hora_llegada'], null)) {
            return false;
        }

        $query = "INSERT INTO " . $this->table . " (id_ruta, id_bus, hora_salida, hora_llegada, estado) 
                  VALUES (:id_ruta, :id_bus, :hora_salida, :hora_llegada, :estado)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta'], PDO::PARAM_INT);
        $stmt->bindParam(':id_bus', $data['id_bus'], PDO::PARAM_INT);
        $stmt->bindParam(':hora_salida', $data['hora_salida']);
        $stmt->bindParam(':hora_llegada', $data['hora_llegada']);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function update_horario($id_horario, $data)
    {
        // Verificar reservas activas
        if ($this->has_active_reservas($id_horario)) {
            return false;
        }

        // Validar existencia de ruta
        $query = "SELECT COUNT(*) FROM ruta WHERE id_ruta = :id_ruta AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta'], PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return false;
        }

        // Validar bus activo
        $query = "SELECT COUNT(*) FROM bus WHERE id_bus = :id_bus AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $data['id_bus'], PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return false;
        }

        // Validar disponibilidad del bus
        if (!$this->check_bus_availability($data['id_bus'], $data['hora_salida'], $data['hora_llegada'], $id_horario)) {
            return false;
        }

        // Actualizar horario
        $query = "UPDATE " . $this->table . " 
                  SET id_ruta = :id_ruta, id_bus = :id_bus, hora_salida = :hora_salida, 
                      hora_llegada = :hora_llegada, estado = :estado 
                  WHERE id_horario = :id_horario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta'], PDO::PARAM_INT);
        $stmt->bindParam(':id_bus', $data['id_bus'], PDO::PARAM_INT);
        $stmt->bindParam(':hora_salida', $data['hora_salida']);
        $stmt->bindParam(':hora_llegada', $data['hora_llegada']);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_BOOL);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete_horario($id_horario)
    {
        // Verificar reservas activas
        if ($this->has_active_reservas($id_horario)) {
            return false; // No se puede eliminar si hay reservas activas
        }

        // Verificar existencia del horario
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id_horario = :id_horario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return null;
        }

        // Eliminar horario
        $query = "DELETE FROM " . $this->table . " WHERE id_horario = :id_horario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function check_bus_availability($id_bus, $hora_salida, $hora_llegada, $exclude_id_horario = null)
    {
        $query = "SELECT COUNT(*) 
                  FROM " . $this->table . " 
                  WHERE id_bus = :id_bus 
                  AND estado = 1
                  AND (
                      (:hora_salida BETWEEN hora_salida AND hora_llegada)
                      OR (:hora_llegada BETWEEN hora_salida AND hora_llegada)
                      OR (hora_salida BETWEEN :hora_salida AND :hora_llegada)
                  )";
        if ($exclude_id_horario !== null) {
            $query .= " AND id_horario != :exclude_id_horario";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $id_bus, PDO::PARAM_INT);
        $stmt->bindParam(':hora_salida', $hora_salida);
        $stmt->bindParam(':hora_llegada', $hora_llegada);
        if ($exclude_id_horario !== null) {
            $stmt->bindParam(':exclude_id_horario', $exclude_id_horario, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    private function has_active_reservas($id_horario)
    {
        $query = "SELECT COUNT(*) 
                  FROM reserva 
                  WHERE id_horario = :id_horario 
                  AND estado IN ('reservada', 'pagada')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>