<?php
class Horario {
    public $id_horario;
    public $id_ruta;
    public $id_bus;
    public $hora_salida;
    public $hora_llegada;
    public $estado;

    public function getIdHorario() {
        return $this->id_horario;
    }

    public function setIdHorario($id_horario) {
        $this->id_horario = $id_horario;
    }

    public function getIdRuta() {
        return $this->id_ruta;
    }

    public function setIdRuta($id_ruta) {
        $this->id_ruta = $id_ruta;
    }

    public function getIdBus() {
        return $this->id_bus;
    }

    public function setIdBus($id_bus) {
        $this->id_bus = $id_bus;
    }

    public function getHoraSalida() {
        return $this->hora_salida;
    }

    public function setHoraSalida($hora_salida) {
        $this->hora_salida = $hora_salida;
    }

    public function getHoraLlegada() {
        return $this->hora_llegada;
    }

    public function setHoraLlegada($hora_llegada) {
        $this->hora_llegada = $hora_llegada;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}