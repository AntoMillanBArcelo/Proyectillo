<?php
class Autocargador
{
    public static function autocargar()
    {
        spl_autoload_register('self::autocarga');
    }

    private static function autocarga($nombreClase)
    {
        $directorioBase = __DIR__;
        $nombreClase = str_replace('\\', DIRECTORY_SEPARATOR, $nombreClase);
        $rutaArchivo = $directorioBase . DIRECTORY_SEPARATOR . $nombreClase . '.php';
        if (file_exists($rutaArchivo)) {
            require_once $rutaArchivo;
        } else {
            echo "Clase no encontrada: $nombreClase";
        }
    }
}
Autocargador::autocargar();
