<?php
class Reserva {
    public $id_reserva;
    public $id_horario;
    public $cantidad_asientos;
    public $estado;
    public $codigo_boleto;
    public $correo_cliente;
    public $fecha_reserva;

    public function getIdReserva() {
        return $this->id_reserva;
    }

    public function setIdReserva($id_reserva) {
        $this->id_reserva = $id_reserva;
    }

    public function getIdHorario() {
        return $this->id_horario;
    }

    public function setIdHorario($id_horario) {
        $this->id_horario = $id_horario;
    }

    public function getCantidadAsientos() {
        return $this->cantidad_asientos;
    }

    public function setCantidadAsientos($cantidad_asientos) {
        $this->cantidad_asientos = $cantidad_asientos;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getCodigoBoleto() {
        return $this->codigo_boleto;
    }

    public function setCodigoBoleto($codigo_boleto) {
        $this->codigo_boleto = $codigo_boleto;
    }

    public function getCorreoCliente() {
        return $this->correo_cliente;
    }

    public function setCorreoCliente($correo_cliente) {
        $this->correo_cliente = $correo_cliente;
    }

    public function getFechaReserva() {
        return $this->fecha_reserva;
    }

    public function setFechaReserva($fecha_reserva) {
        $this->fecha_reserva = $fecha_reserva;
    }
}