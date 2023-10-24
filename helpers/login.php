<?php
    require_once "metodosSesion.php";

    function guardaSesion($user, $usuario)
    {
        iniciaSesion();
        $_SESSION[$user]=$usuario ;
    }

    function estaLogeado()
    {
        //mirar en la clase $session si esta la clave user
    }
?>