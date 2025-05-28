<?php
interface InterfaceReservaDAO {
    public function read_all_reservas();
    public function read_single_reserva($id_reserva);
}