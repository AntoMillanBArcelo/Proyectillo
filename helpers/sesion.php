<?php
    function iniciaSesion()
    {
        session_start();
    }

    function cierraSesion($location)
    {
        session_destroy();
        if (!empty($location)) 
        {
            header('Location: '.$location);
        }
    }
?>