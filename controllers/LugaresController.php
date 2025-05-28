<?php
include_once 'dao/LugarDAO.php';

class LugaresController
{
    private $db;
    private $lugarDAO;

    public function __construct($db)
    {
        $this->db = $db;
        $this->lugarDAO = new LugarDAO($db);
    }

    public function getAllLugares()
    {
        $stmt = $this->lugarDAO->read_all_lugares();
        $lugaresResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::send(200, $lugaresResponse);
    }

    public function getLugarById($data)
    {
        if (!isset($data['id_lugar']) || !is_numeric($data['id_lugar'])) {
            Response::send(400, ['message' => 'ID de lugar inválido']);
            return;
        }
        $stmt = $this->lugarDAO->read_single_lugar($data['id_lugar']);
        $lugarResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($lugarResponse)) {
            Response::send(404, ['message' => 'Lugar no encontrado']);
        } else {
            Response::send(200, $lugarResponse);
        }
    }

    public function insertLugar($data)
    {
        if (!isset($data['nombre']) || empty(trim($data['nombre']))) {
            Response::send(400, ['message' => 'El nombre es obligatorio']);
            return;
        }
        if ($this->lugarDAO->insert_lugar($data)) {
            Response::send(200, ['message' => 'Lugar insertado']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error en el controlador del lugar']);
        }
    }

    public function updateLugar($id_lugar, $data)
    {
        if (!isset($data['nombre']) || empty(trim($data['nombre']))) {
            Response::send(400, ['message' => 'El nombre es obligatorio']);
            return;
        }
        if ($this->lugarDAO->update_lugar($id_lugar, $data)) {
            Response::send(200, ['message' => 'Lugar actualizado']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error en el controlador del lugar']);
        }
    }

    public function deleteLugar($data)
    {
        if (!isset($data['id_lugar']) || !is_numeric($data['id_lugar'])) {
            Response::send(400, ['message' => 'ID de lugar inválido']);
            return;
        }
        if ($this->lugarDAO->delete_lugar($data)) {
            Response::send(200, ['message' => 'Lugar borrado']);
        } else {
            Response::send(500, ['message' => 'Ocurrió un error en el controlador del lugar']);
        }
    }
}