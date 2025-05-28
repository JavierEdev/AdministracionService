<?php
interface InterfaceHorarioDAO {
    public function read_by_ruta($id_ruta);
    public function read_single_horario($id_horario);
    public function insert_horario($data);
    public function update_horario($id_horario, $data);
    public function delete_horario($id_horario);
    public function check_bus_availability($id_bus, $hora_salida, $hora_llegada, $exclude_id_horario = null);
    public function has_active_reservas($id_horario);
}