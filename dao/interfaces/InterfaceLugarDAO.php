<?php
interface InterfaceLugarDAO {
    public function read_all_lugares();
    public function read_single_lugar($id_lugar);
    public function insert_lugar($data);
    public function update_lugar($id_lugar, $data);
    public function delete_lugar($data);
}