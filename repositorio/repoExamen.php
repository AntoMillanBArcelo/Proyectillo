<?php
    class repoExamen 
    {

        private $con;

        public function __construct($con) {
            $this->con = $con;
        }
    
        public  function getById($id) 
        {
            $id = filter_var($id);       
            $query = "SELECT * FROM examen WHERE id = $id";
            $result = $this->con->query($query);
        
            if ($result)
             {
                $examenData = $result->fetch(PDO::FETCH_ASSOC);
        
                if ($examenData) 
                {
                    return new Examen($examenData['fechaIni']);
                }
                 else 
                {
                    return null;
                }
            } 
            else 
            {
                return null;
            }
        }
    
        public function mostrarTodos() 
        {
            $query = "SELECT * from examen";
            $result = $this->con->query($query);
        }
        
        public function insert(Examen $examen) {         
            $query = "INSERT INTO examen (fechaIni) VALUES (:fechaIni)";
            $stmt = $this->con->prepare($query);
            
            $fechaIni = $examen->getFechaIni();
            $stmt->bindParam(":fechaIni", $fechaIni, PDO::PARAM_STR);
        
            return $stmt->execute();
        }
        
        
    
        public function update($id, $fechaIni) 
        {
            $query = "UPDATE examen SET fechaIni = :fechaIni WHERE id = :id";
            $stmt = $this->con->prepare($query);
        
            // Obtener la fechaIni directamente del objeto $examen
            $fechaIni = $examen->getFechaIni();

            $stmt->bindParam(":fechaIni", $fechaIni, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
            return $stmt->execute();
        }
    
        public function delete($id) { 
            $query = "DELETE FROM examen WHERE id = :id";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
            return $stmt->execute();
        }
    }