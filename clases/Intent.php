<?php
class Intent {
    private $fechaIni;
    private $intentos;

    public function __construct($fechaIni, $intentos) {
        $this->fechaIni = $fechaIni;
        $this->intentos = $intentos;
    }

    public function getFechaIni() {
        return $this->fechaIni;
    }

    public function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    public function getIntentos() {
        return $this->intentos;
    }

    public function setIntentos($intentos) {
        $this->intentos = $intentos;
    }
}
