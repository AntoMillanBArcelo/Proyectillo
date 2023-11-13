<?php
class Usuario implements \JsonSerializable{
    private $correo;
    private $contrasena;
    private $rol;

    public function __construct($correo, $contrasena, $rol) {
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function toJSON(){

    }
}
