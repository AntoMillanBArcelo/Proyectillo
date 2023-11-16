<?php
    class repoPregunta 
    {
    
        private $con;

        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) 
        {
            $query = "SELECT * FROM `pregunta` WHERE id = $id";
            $result = $this->con->query($query);
        
            if ($result) {
                $rowCount = $result->rowCount(); // Utiliza rowCount en PDO
        
                if ($rowCount > 0) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $pregunta = new Pregunta(
                        $row['enunciado'],
                        $row['respuesta1'],
                        $row['respuesta2'],
                        $row['respuesta3'],
                        $row['correcta'],
                        $row['url'],
                        $row['tipoUrl']
                    );
                    return $pregunta;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } 
    
        public function insert($enunciado, $respuesta1, $respuesta2, $respuesta3, $correcta, $url, $tipoUrl) {         
            $insert = $this->con->query("INSERT INTO pregunta (enunciado, respuesta1, respuesta2, respuesta3, correcta, url, tipoUrl ) VALUES ('$enunciado', '$respuesta1', '$respuesta2', '$respuesta3', '$correcta', '$url', '$tipoUrl')");
        }
      
        public function insertObjeto(Pregunta $pregunta) 
        {         
            $insert = $this->con->query("INSERT INTO pregunta (enunciado, respuesta1, respuesta2, respuesta3, correcta, url, tipoUrl ) VALUES ('$pregunta->enunciado', '$pregunta->respuesta1', '$pregunta->respuesta2', '$pregunta->respuesta3', '$pregunta->correcta', '$pregunta->url', '$pregunta->tipoUrl')");
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