<?php
    class repoUsuario 
    {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id === false || $id === null) {
                // Manejar el caso en que el ID no sea válido
                return null;
            }
        
            $query = "SELECT * FROM usuario WHERE id = $id";
            $result = $this->con->query($query);
        
            if ($result) {
                $usuario = $result->fetch(PDO::FETCH_ASSOC);
                return $usuario;
            } else {
                // Manejar el caso en que la consulta no fue exitosa
                return null;
            }
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert( $correo, $contrasena, ) 
        {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $correoLimpio = filter_var($correo, FILTER_SANITIZE_EMAIL);
            $contrasenaEncriptada = md5($contrasena);
            
            // Utiliza una sentencia preparada para insertar datos de manera segura
            $stmt = $this->con->prepare("INSERT INTO usuario (correo, contrasena) VALUES (:correo, :contrasena)");
            $stmt->bindParam(':correo', $correoLimpio, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasenaEncriptada, PDO::PARAM_STR);
            
            if ($stmt->execute()) 
            {
            return true; // La inserción fue exitosa
            } 
            else 
            {
            return false; // La inserción falló
            }
            
        }
    
        public function update($id, $correo, $contrasena) {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $correoLimpio = filter_var($correo, FILTER_SANITIZE_EMAIL);
            $contrasenaEncriptada = md5($contrasena);
            $query = "UPDATE usuario SET correo = '$correoLimpio', contrasena = '$contrasenaEncriptada' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $query = "DELETE FROM usuario WHERE id = $id";
            $result = $this->con->query($query);
        }
    }