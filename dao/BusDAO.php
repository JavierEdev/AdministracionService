<?php
include_once __DIR__ . '/../dao/interfaces/InterfaceBusDAO.php';

class BusDAO implements InterfaceBusDAO {
    private $conn;
    private $table = 'bus';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_all_buses() {
        $query = "SELECT b.id_bus, b.placa, b.capacidad, b.estado, 
                         (SELECT COUNT(*) FROM horario h WHERE h.id_bus = b.id_bus AND h.estado = 1) = 0 AS disponible
                  FROM " . $this->table . " b";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single_bus($id_bus) {
        $query = "SELECT b.id_bus, b.placa, b.capacidad, b.estado, 
                         (SELECT COUNT(*) FROM horario h WHERE h.id_bus = b.id_bus AND h.estado = 1) = 0 AS disponible
                  FROM " . $this->table . " b
                  WHERE b.id_bus = :id_bus LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $id_bus);
        $stmt->execute();
        return $stmt;
    }

    public function insert_bus($data) {
        $query = "INSERT INTO " . $this->table . " (placa, capacidad, estado) 
                  VALUES (:placa, :capacidad, :estado)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $data['placa']);
        $stmt->bindParam(':capacidad', $data['capacidad'], PDO::PARAM_INT);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update_bus($id_bus, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET placa = :placa, capacidad = :capacidad, estado = :estado 
                  WHERE id_bus = :id_bus";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $data['placa']);
        $stmt->bindParam(':capacidad', $data['capacidad'], PDO::PARAM_INT);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_INT);
        $stmt->bindParam(':id_bus', $id_bus);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete_bus($data) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id_bus = :id_bus";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $data['id_bus']);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return null;
        }

        // Verificar si el bus está asignado a horarios
        $query = "SELECT COUNT(*) FROM horario WHERE id_bus = :id_bus";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $data['id_bus']);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        // Intentar eliminar el bus
        $query = "DELETE FROM " . $this->table . " WHERE id_bus = :id_bus";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_bus', $data['id_bus']);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
        return false;
    }
}