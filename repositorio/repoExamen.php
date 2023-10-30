<?php
    class repoExamen 
    {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
          
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert($fechaIni) {         
            $insert = $this->con->query("INSERT INTO examen (fechaIni) VALUES ('$fechaIni')");
        }
    
        public function update($id, $fechaIni) {
            $query = "UPDATE examen SET fechaIni = '$fechaIni' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) {
            $query = "DELETE FROM examen WHERE id = $id";
            $result = $this->con->query($query);
        }
    }