<?php
    class repoPregunta 
    {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
          
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert($enunciado, $respuesta1, $respuesta2, $respuesta3, $correcta, $url, $tipoUrl) {         
            $insert = $this->con->query("INSERT INTO pregunta (enunciado, respuesta1, respuesta2, respuesta3, correcta, url, tipoUrl ) VALUES ('$enunciado', '$respuesta1', '$respuesta2', '$respuesta3', '$correcta', '$url', '$tipoUrl')");
        }
    
        public function update($id, $enunciado, $respuesta1, $respuesta2, $respuesta3, $correcta, $url, $tipoUrl) {
            $query = "UPDATE pregunta SET enunciado = '$enunciado', respuesta1 = '$respuesta1', respuesta2 = '$respuesta2', respuesta3 = '$respuesta3', correcta = '$correcta', url = '$url', tipoUrl='$tipoUrl' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) {
            $query = "DELETE FROM pregunta WHERE id = $id";
            $result = $this->con->query($query);
        }
    }