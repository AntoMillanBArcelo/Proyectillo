<?php
if (isset($_GET['menu'])) 
{
    /* if ($_GET['menu'] == "inicio") 
    {
        require_once './vistas/principal/fondo.php';
    } */
    if ($_GET['menu'] == "menuAdmin") 
    {
        require_once './vistas/mantenimiento/menuAdmin.php';
    }
    if ($_GET['menu'] == "cerrarsesion") 
    {
        require_once './vistas/login/cerrarsesion.php';
    }   
    if ($_GET['menu'] == "login") 
    {
        require_once './vistas/principal/login.php';
    }
    if ($_GET['menu'] == "crudUsuario") 
    {
        require_once './vistas/mantenimiento/crudUsuario.php';
    }
    if ($_GET['menu'] == "crudExamenes") 
    {
        require_once './vistas/mantenimiento/crudExamenes.php';
    }
    if ($_GET['menu'] == "register") 
    {
        require_once './vistas/principal/register.php';
    }
    if ($_GET['menu'] == "examen") 
    {
        require_once './plantilla/examen.php';
    }   
    if ($_GET['menu'] == "alumno") 
    {
        require_once './vistas/principal/alumno.php';
    }  
    if ($_GET['menu'] == "pregunta") 
    {
        require_once './vistas/mantenimiento/crudPregunta.php';
    } 
}

