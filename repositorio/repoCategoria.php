<?php
    class repoCategoria 
    {
        private $con;
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
            $stmt = $this->con->prepare("SELECT * FROM categoria WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function getByNombre($nombre) {
            $stmt = $this->con->prepare("SELECT * FROM categoria WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function insert($nombre) {         
            $stmt = $this->con->prepare("INSERT INTO categoria (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            return $stmt->execute();
        }
    
        public function update($id, $nombre) {
            $stmt = $this->con->prepare("UPDATE categoria SET nombre = :nombre WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            return $stmt->execute();
        }
    
        public function delete($id) {
            $stmt = $this->con->prepare("DELETE FROM categoria WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
    