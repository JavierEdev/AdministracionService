<?php
include_once 'models/Horario.php';

class HorariosController
{
    private $db;
    private $horario;

    public function __construct($db)
    {
        $this->db = $db;
        $this->horario = new Horario($db);
    }

    public function getHorariosByRuta($data)
    {
        if (!isset($data['id_ruta']) || !is_numeric($data['id_ruta'])) {
            Response::send(400, ['message' => 'ID de ruta inválido']);
            return;
        }
        $stmt = $this->horario->read_by_ruta($data['id_ruta']);
        $horariosResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::send(200, $horariosResponse);
    }

    public function getHorarioById($data)
    {
        if (!isset($data['id_horario']) || !is_numeric($data['id_horario'])) {
            Response::send(400, ['message' => 'ID de horario inválido']);
            return;
        }
        $stmt = $this->horario->read_single_horario($data['id_horario']);
        $horarioResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($horarioResponse)) {
            Response::send(404, ['message' => 'Horario no encontrado']);
        } else {
            Response::send(200, $horarioResponse);
        }
    }

    public function insertHorario($data)
    {
        if (!isset($data['id_ruta']) || !is_numeric($data['id_ruta'])) {
            Response::send(400, ['message' => 'ID de ruta inválido']);
            return;
        }
        if (!isset($data['id_bus']) || !is_numeric($data['id_bus'])) {
            Response::send(400, ['message' => 'ID de bus inválido']);
            return;
        }
        if (!isset($data['hora_salida']) || !strtotime($data['hora_salida'])) {
            Response::send(400, ['message' => 'Hora de salida inválida']);
            return;
        }
        if (!isset($data['hora_llegada']) || !strtotime($data['hora_llegada'])) {
            Response::send(400, ['message' => 'Hora de llegada inválida']);
            return;
        }
        if (strtotime($data['hora_salida']) >= strtotime($data['hora_llegada'])) {
            Response::send(400, ['message' => 'La hora de salida debe ser anterior a la hora de llegada']);
            return;
        }
        $data['estado'] = isset($data['estado']) && is_numeric($data['estado']) ? (bool)$data['estado'] : true;

        if ($this->horario->insert_horario($data)) {
            Response::send(200, ['message' => 'Horario insertado']);
        } else {
            Response::send(400, ['message' => 'No se pudo insertar el horario. Verifique que la ruta y el bus existan, estén activos y que el bus esté disponible']);
        }
    }

    public function updateHorario($data)
    {
        if (!isset($data['id_horario']) || !is_numeric($data['id_horario'])) {
            Response::send(400, ['message' => 'ID de horario inválido']);
            return;
        }
        if (!isset($data['id_ruta']) || !is_numeric($data['id_ruta'])) {
            Response::send(400, ['message' => 'ID de ruta inválido']);
            return;
        }
        if (!isset($data['id_bus']) || !is_numeric($data['id_bus'])) {
            Response::send(400, ['message' => 'ID de bus inválido']);
            return;
        }
        if (!isset($data['hora_salida']) || !strtotime($data['hora_salida'])) {
            Response::send(400, ['message' => 'Hora de salida inválida']);
            return;
        }
        if (!isset($data['hora_llegada']) || !strtotime($data['hora_llegada'])) {
            Response::send(400, ['message' => 'Hora de llegada inválida']);
            return;
        }
        if (strtotime($data['hora_salida']) >= strtotime($data['hora_llegada'])) {
            Response::send(400, ['message' => 'La hora de salida debe ser anterior a la hora de llegada']);
            return;
        }
        $data['estado'] = isset($data['estado']) && is_numeric($data['estado']) ? (bool)$data['estado'] : true;

        if ($this->horario->update_horario($data['id_horario'], $data)) {
            Response::send(200, ['message' => 'Horario actualizado']);
        } else {
            Response::send(400, ['message' => 'No se pudo actualizar el horario. Verifique que no haya reservas activas, que la ruta y el bus existan, estén activos y que el bus esté disponible']);
        }
    }

    public function deleteHorario($data)
    {
        if (!isset($data['id_horario']) || !is_numeric($data['id_horario'])) {
            Response::send(400, ['message' => 'ID de horario inválido']);
            return;
        }
        $result = $this->horario->delete_horario($data['id_horario']);
        if ($result === null) {
            Response::send(404, ['message' => 'Horario no encontrado']);
        } elseif ($result === false) {
            Response::send(400, ['message' => 'No se puede eliminar el horario porque tiene reservas activas']);
        } else {
            Response::send(200, ['message' => 'Horario eliminado']);
        }
    }
}
?>