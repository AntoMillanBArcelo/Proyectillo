<?php
class Examen {
    private $fechaIni;

    public function __construct($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    public function getFechaIni() {
        return $this->fechaIni;
    }

    public function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }
}