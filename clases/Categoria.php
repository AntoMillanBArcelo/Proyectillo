<?php
class Categoria{
    private $nombre;

    public function __construct($nombre) {
        $this->nombre = $nombre
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nobre) {
        $this->nombre = $nombre;
    }
}