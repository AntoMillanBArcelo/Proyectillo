<?php
    class db
    {
        private static $conexion = null;
        
        public static function obtenerConexion() 
        {
            if (self::$conexion === null) 
            {
                self::$conexion = new PDO('mysql:host=localhost;dbname=autoescuela', 'antonio', 'root');
            }
            return self::$conexion;
        }
    }
?>    
