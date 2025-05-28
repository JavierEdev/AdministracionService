<?php
interface InterfaceRutaDAO {
    public function read_all_rutas();
    public function read_single_ruta($id_ruta);
    public function insert_ruta($data);
    public function update_ruta($id_ruta, $data);
    public function delete_ruta($data);
}