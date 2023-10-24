<?php
    class repoUsuario {
    
        public function __construct($con) {
            $this->con = $con;
        }
    
        public function getById($id) {
          
        }
    
        public function getByCorreo($correo) {

        }
    
        public function insert( $correo, $contrasena) {
            //FILTER_SANITIZE_EMAIL sirve para evitar problemas de seguridad antes de meterlos en la base de datos
            $correoLimpio = filter_var($correo, FILTER_SANITIZE_EMAIL);
            $contrasenaEncriptada = md5($contrasena); 
            $insert = $this->con->query("INSERT INTO usuario (correo, contrasena) VALUES ('$correoLimpio', '$contrasenaEncriptada')");
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