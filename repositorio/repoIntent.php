<?php
    class repoIntent 
    {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
          
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert($fecha, $intentos) {         
            $insert = $this->con->query("INSERT INTO intent (fecha, intentos) VALUES ('$fecha', '$intentos')");
        }
    
        public function update($id, $fecha, $intentos) {
            $query = "UPDATE intent SET fecha = '$fecha', intentos = '$intentos' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) {
            $query = "DELETE FROM intent WHERE id = $id";
            $result = $this->con->query($query);
        }
    }