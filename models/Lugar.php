<?php
class Lugar {
    public $id_lugar;
    public $nombre;

    public function getIdLugar() {
        return $this->id_lugar;
    }

    public function setIdLugar($id_lugar) {
        $this->id_lugar = $id_lugar;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
}