<?php
    class repoIntent 
    {
        private $con;
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) 
        {
            $stmt = $this->con->prepare("SELECT * FROM intent WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function insert($fecha, $intentos) 
        {
            $stmt = $this->con->prepare("INSERT INTO intent (fecha, intentos) VALUES (:fecha, :intentos)");
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':intentos', $intentos, PDO::PARAM_INT);
            return $stmt->execute();
        }
    
        public function update($id, $fecha, $intentos) 
        {
            $stmt = $this->con->prepare("UPDATE intent SET fecha = :fecha, intentos = :intentos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':intentos', $intentos, PDO::PARAM_INT);
            return $stmt->execute();
        }
    
        public function delete($id) 
        {
            $stmt = $this->con->prepare("DELETE FROM intent WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
    