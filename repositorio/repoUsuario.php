<?php
    class repoUsuario 
    {
    
        private $con;
        
        public function __construct($con) 
        {
            $this->con = $con;
        }
    
        public function getById($id) 
        {
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id === false || $id === null) 
            {
                return null;
            }
        
            $query = "SELECT * FROM usuario WHERE id = $id";
            $result = $this->con->query($query);
        
            if ($result) 
            {
                $usuario = $result->fetch(PDO::FETCH_ASSOC);
                return $usuario;
            } 
            else 
            {
                return null;
            }
        }
    
        public function insert($correo, $contrasena, $rol) 
        {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $correoLimpio = filter_var($correo, FILTER_SANITIZE_EMAIL);
            $contrasenaEncriptada = md5($contrasena);
            
            $stmt = $this->con->prepare("INSERT INTO usuario (correo, contrasena, rol) VALUES (:correo, :contrasena, :rol)");
            $stmt->bindParam(':correo', $correoLimpio, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasenaEncriptada, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            
            if ($stmt->execute()) 
            {
                // Se añadió el usuario
                return true; 
            } 
            else 
            {
                // No se pudo añadir el usuario
                return false; 
            }
        }

        /* Este insert se usa solo en el register y la diferencia es que no tiene para añadir el rol */
        public function insertRegister($correo, $contrasena) 
        {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $correoLimpio = filter_var($correo, FILTER_SANITIZE_EMAIL);
            $contrasenaEncriptada = md5($contrasena);
            
            $stmt = $this->con->prepare("INSERT INTO usuario (correo, contrasena) VALUES (:correo, :contrasena)");
            $stmt->bindParam(':correo', $correoLimpio, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasenaEncriptada, PDO::PARAM_STR);
            
            if ($stmt->execute()) 
            {
                // Se añadió el usuario
                return true;
            } 
            else 
            {
                // No se pudo añadir el usuario
                return false;
            }
        }

    
        public function update($id, $correo, $contrasena, $rol) 
        {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $correoLimpio = filter_var($correo, FILTER_SANITIZE_EMAIL);
            $contrasenaEncriptada = md5($contrasena);
            $query = "UPDATE usuario SET correo = '$correoLimpio', contrasena = '$contrasenaEncriptada', rol = '$rol' WHERE id = $id";
            $result = $this->con->query($query);
        }
    
        public function delete($id) 
        {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $query = "DELETE FROM usuario WHERE id = $id";
            $result = $this->con->query($query);
        }
    }