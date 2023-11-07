<?php
if (isset($_GET['menu'])) 
{

    if ($_GET['menu'] == "inicio") 
    {
        require_once 'index.php';
    }
    if ($_GET['menu'] == "menuAdmin") 
    {
        require_once '../mantenimiento/menuAdmin.php';
    }
    if ($_GET['menu'] == "cerrarsesion") 
    {
        require_once './vistas/login/cerrarsesion.php';
    }   
    if ($_GET['menu'] == "login") 
    {
        require_once './vistas/principal/login.php';
    }
}
else
{
    require_once './vistas/principal/fondo.php';
}
