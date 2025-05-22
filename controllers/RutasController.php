<?php
include_once 'models/Ruta.php';

class RutasController
{
    private $db;
    private $ruta;

    public function __construct($db)
    {
        $this->db = $db;
        $this->ruta = new Ruta($db);
    }

    public function getAllRutas()
    {
        $stmt = $this->ruta->read_all_rutas();
        $rutasResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::send(200, $rutasResponse);
    }

    public function getRutaById($data)
    {
        if (!isset($data['id_ruta']) || !is_numeric($data['id_ruta'])) {
            Response::send(400, ['message' => 'ID de ruta inválido']);
            return;
        }
        $stmt = $this->ruta->read_single_ruta($data['id_ruta']);
        $rutaResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rutaResponse)) {
            Response::send(404, ['message' => 'Ruta no encontrada']);
        } else {
            Response::send(200, $rutaResponse);
        }
    }

    public function insertRuta($data)
    {
        if (!isset($data['descripcion']) || empty(trim($data['descripcion']))) {
            Response::send(400, ['message' => 'La descripción es obligatoria']);
            return;
        }
        if (!isset($data['id_origen']) || !is_numeric($data['id_origen'])) {
            Response::send(400, ['message' => 'ID de origen inválido']);
            return;
        }
        if (!isset($data['id_destino']) || !is_numeric($data['id_destino'])) {
            Response::send(400, ['message' => 'ID de destino inválido']);
            return;
        }
        if ($data['id_origen'] == $data['id_destino']) {
            Response::send(400, ['message' => 'Origen y destino no pueden ser iguales']);
            return;
        }
        // Verificar que id_origen y id_destino existan en la tabla lugar
        $query = "SELECT COUNT(*) FROM lugar WHERE id_lugar IN (:id_origen, :id_destino)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_origen', $data['id_origen']);
        $stmt->bindParam(':id_destino', $data['id_destino']);
        $stmt->execute();
        if ($stmt->fetchColumn() != 2) {
            Response::send(400, ['message' => 'Origen o destino no existen']);
            return;
        }
        // Establecer activo por defecto a 1 si no se proporciona
        $data['activo'] = isset($data['activo']) && is_numeric($data['activo']) ? $data['activo'] : 1;
        if ($this->ruta->insert_ruta($data)) {
            Response::send(200, ['message' => 'Ruta insertada']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error en el controlador de la ruta']);
        }
    }

    public function updateRuta($id_ruta, $data)
    {
        if (!isset($data['descripcion']) || empty(trim($data['descripcion']))) {
            Response::send(400, ['message' => 'La descripción es obligatoria']);
            return;
        }
        if (!isset($data['id_origen']) || !is_numeric($data['id_origen'])) {
            Response::send(400, ['message' => 'ID de origen inválido']);
            return;
        }
        if (!isset($data['id_destino']) || !is_numeric($data['id_destino'])) {
            Response::send(400, ['message' => 'ID de destino inválido']);
            return;
        }
        if ($data['id_origen'] == $data['id_destino']) {
            Response::send(400, ['message' => 'Origen y destino no pueden ser iguales']);
            return;
        }
        // Verificar que id_origen y id_destino existan en la tabla lugar
        $query = "SELECT COUNT(*) FROM lugar WHERE id_lugar IN (:id_origen, :id_destino)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_origen', $data['id_origen']);
        $stmt->bindParam(':id_destino', $data['id_destino']);
        $stmt->execute();
        if ($stmt->fetchColumn() != 2) {
            Response::send(400, ['message' => 'Origen o destino no existen']);
            return;
        }
        // Asegurar que activo sea 0 o 1
        $data['activo'] = isset($data['activo']) && is_numeric($data['activo']) ? $data['activo'] : 1;
        if ($this->ruta->update_ruta($id_ruta, $data)) {
            Response::send(200, ['message' => 'Ruta actualizada']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error en el controlador de la ruta']);
        }
    }

    public function deleteRuta($data)
    {
        if (!isset($data['id_ruta']) || !is_numeric($data['id_ruta'])) {
            Response::send(400, ['message' => 'ID de ruta inválido']);
            return;
        }
        $result = $this->ruta->delete_ruta($data);
        if ($result === null) {
            Response::send(404, ['message' => 'Ruta no encontrada']);
        } elseif ($result === false) {
            Response::send(400, ['message' => 'No se puede eliminar la ruta porque tiene horarios asociados']);
        } else {
            Response::send(200, ['message' => 'Ruta borrada']);
        }
    }
}
?>