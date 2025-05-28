<?php
interface InterfaceBusDAO {
    public function read_all_buses();
    public function read_single_bus($id_bus);
    public function insert_bus($data);
    public function update_bus($id_bus, $data);
    public function delete_bus($data);
}