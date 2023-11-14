<?php
    class db
    {
        private static $conexion = null;
        
        public static function obtenerConexion() 
        {
            if (self::$conexion === null) 
            {
                self::$conexion = new PDO('mysql:host=localhost;dbname=autoescuela', 'root', '');
            }
            return self::$conexion;
        }
    }
?>    
