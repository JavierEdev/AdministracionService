<?php
class Ruta
{
    private $conn;
    private $table = 'ruta';

    public $id_ruta;
    public $descripcion;
    public $id_origen;
    public $id_destino;
    public $activo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_all_rutas()
    {
        $query = "SELECT r.id_ruta, r.descripcion, r.id_origen, r.id_destino, r.activo, 
                         lo.nombre AS origen_nombre, ld.nombre AS destino_nombre 
                  FROM " . $this->table . " r
                  LEFT JOIN lugar lo ON r.id_origen = lo.id_lugar
                  LEFT JOIN lugar ld ON r.id_destino = ld.id_lugar";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single_ruta($id_ruta)
    {
        $query = "SELECT r.id_ruta, r.descripcion, r.id_origen, r.id_destino, r.activo, 
                         lo.nombre AS origen_nombre, ld.nombre AS destino_nombre 
                  FROM " . $this->table . " r
                  LEFT JOIN lugar lo ON r.id_origen = lo.id_lugar
                  LEFT JOIN lugar ld ON r.id_destino = ld.id_lugar
                  WHERE r.id_ruta = :id_ruta LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $id_ruta);
        $stmt->execute();
        return $stmt;
    }

    public function insert_ruta($data)
    {
        $query = "INSERT INTO " . $this->table . " (descripcion, id_origen, id_destino, activo) 
                  VALUES (:descripcion, :id_origen, :id_destino, :activo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':id_origen', $data['id_origen']);
        $stmt->bindParam(':id_destino', $data['id_destino']);
        $stmt->bindParam(':activo', $data['activo'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update_ruta($id_ruta, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET descripcion = :descripcion, id_origen = :id_origen, id_destino = :id_destino, activo = :activo 
                  WHERE id_ruta = :id_ruta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':id_origen', $data['id_origen']);
        $stmt->bindParam(':id_destino', $data['id_destino']);
        $stmt->bindParam(':activo', $data['activo'], PDO::PARAM_INT);
        $stmt->bindParam(':id_ruta', $id_ruta);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete_ruta($data)
    {
        // Verificar si la ruta existe
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id_ruta = :id_ruta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta']);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            return null;
        }

        // Verificar si hay horarios asociados
        $query = "SELECT COUNT(*) FROM horario WHERE id_ruta = :id_ruta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta']);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        // Intentar eliminar la ruta
        $query = "DELETE FROM " . $this->table . " WHERE id_ruta = :id_ruta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ruta', $data['id_ruta']);
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
?>