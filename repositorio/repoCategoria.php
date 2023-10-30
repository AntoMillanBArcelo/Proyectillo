<?php
    class repoCategoria 
    {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
          
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert($fechaIni) {         
            $insert = $this->con->query("INSERT INTO categoria (nombre) VALUES ('$nombre')");
        }
    
        public function update($id, $nombre) {
            $query = "UPDATE categoria SET nombre = '$nombre' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) {
            $query = "DELETE FROM categoria WHERE id = $id";
            $result = $this->con->query($query);
        }
    }