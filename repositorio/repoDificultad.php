<?php
    class repoDificultad 
    {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
          
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert($fechaIni) {         
            $insert = $this->con->query("INSERT INTO dificultad (nombre) VALUES ('$nombre')");
        }
    
        public function update($id, $nombre) {
            $query = "UPDATE dificultad SET nombre = '$nombre' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) {
            $query = "DELETE FROM dificultad WHERE id = $id";
            $result = $this->con->query($query);
        }
    }