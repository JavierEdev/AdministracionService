<?php
class Bus {
    public $id_bus;
    public $placa;
    public $capacidad;
    public $estado;

    public function getIdBus() {
        return $this->id_bus;
    }

    public function setIdBus($id_bus) {
        $this->id_bus = $id_bus;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function setCapacidad($capacidad) {
        $this->capacidad = $capacidad;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}