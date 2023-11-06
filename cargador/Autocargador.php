<?php
class Autocargador
{
    public static function autocargar()
    {

        spl_autoload_register(function($clase){
            $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/';
            $directorios = [
                'api',
                'clases',
                'css',
                'db',
                'diseño',
                'helpers',
                'js',
                'metodos',
                'plantilla',
                'repositorio',
                'servidor'
            ];

            foreach ($directorios as $directorio) {
                $archivo = $baseDir . $directorio . '/' . $clase . '.php';
                if (file_exists($archivo)) {
                    require_once $archivo;
                    return;
                }
            }  

        });
    }
}
    
Autocargador::autocargar();
