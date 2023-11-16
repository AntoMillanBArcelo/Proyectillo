<?php

class UsuarioExamen
{
    private $id;
    private $idUsuario;
    private $idExamen;
    private $estado;

    public function __construct($idUsuario, $idExamen, $estado = 'asignado')
    {
        $this->idUsuario = $idUsuario;
        $this->idExamen = $idExamen;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUSuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getIdExamen() {
        return $this->idExamen;
    }

    public function setIdExamen($idExamen) {
        $this->idExamen = $idExamen;
    }
    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}
