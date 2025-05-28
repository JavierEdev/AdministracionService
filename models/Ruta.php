<?php
class Ruta {
    public $id_ruta;
    public $descripcion;
    public $id_origen;
    public $id_destino;
    public $activo;

    public function getIdRuta() {
        return $this->id_ruta;
    }

    public function setIdRuta($id_ruta) {
        $this->id_ruta = $id_ruta;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getIdOrigen() {
        return $this->id_origen;
    }

    public function setIdOrigen($id_origen) {
        $this->id_origen = $id_origen;
    }

    public function getIdDestino() {
        return $this->id_destino;
    }

    public function setIdDestino($id_destino) {
        $this->id_destino = $id_destino;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }
}