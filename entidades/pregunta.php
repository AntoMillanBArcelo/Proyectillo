<?php
class Pregunta {
    private $enunciado;
    private $respuesta1;
    private $respuesta2;
    private $respuesta3;
    private $correcta;
    private $url;
    private $tipoUrl;

    public function __construct($enunciado, $respuesta1, $respuesta2, $respuesta3, $correcta, $url, $tipoUrl) {
        $this->enunciado = $enunciado;
        $this->respuesta1 = $respuesta1;
        $this->respuesta2 = $respuesta2;
        $this->respuesta3 = $respuesta3;
        $this->correcta = $correcta;
        $this->url = $url;
        $this->tipoUrl = $tipoUrl;
    }

    public function getEnunciado() {
        return $this->enunciado;
    }

    public function getRespuesta1() {
        return $this->respuesta1;
    }

    public function getRespuesta2() {
        return $this->respuesta2;
    }

    public function getRespuesta3() {
        return $this->respuesta3;
    }

    public function getCorrecta() {
        return $this->correcta;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getTipoUrl() {
        return $this->tipoUrl;
    }
}
