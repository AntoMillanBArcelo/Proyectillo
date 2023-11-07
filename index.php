<?php
class Principal
{
    public static function main()
    {
        require_once './cargador/Autocargador.php';
        require_once './vistas/principal/layout.php';
    }
}
Principal::main();
?>
