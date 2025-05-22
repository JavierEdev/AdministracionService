<?php
class Lugar
{
    private $conn;
    private $table = 'lugar';

    public $id_lugar;
    public $nombre;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_all_lugares()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single_lugar($id_lugar)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_lugar = :id_lugar LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_lugar', $id_lugar);
        $stmt->execute();
        return $stmt;
    }

    public function insert_lugar($data)
    {
        $query = "INSERT INTO " . $this->table . " (nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update_lugar($id_lugar, $data)
    {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre WHERE id_lugar = :id_lugar";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':id_lugar', $id_lugar);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete_lugar($data)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_lugar = :id_lugar";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_lugar', $data['id_lugar']);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
        return false;
    }
}
?>