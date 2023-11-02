<?php
include_once 'metodos/MetodoPintaMenu.php';
include_once 'db/db.php';
include 'clases/Usuario.php';
// Llama a la función crearMenu de la clase MetodoPintaMenu para generar el menú.
MetodoPintaMenu::crearMenu();
$con = db::obtenerConexion();
session_start();

// Corrige los enlaces del menú
echo '<li><a href="plantilla/plantillaPregunta.html">Pregunta</a></li>';
echo '<li><a href="plantilla/examen.html">Examen</a></li>';


// Verifica si el usuario ha iniciado sesión antes de mostrar su información.
if (isset($_SESSION['user'])) 
{
    echo 'Usuario: ' . $_SESSION['user']->getCorreo(); // Utiliza -> para acceder al método
    if ($_SESSION['user']->getRol() === 'admin') {
        echo '<li><a href="crudUsuario.php">Administrar Usuarios</a></li>';
    }
    var_dump($_SESSION['user']->getRol());
} else {
    echo 'Usuario no ha iniciado sesión';
}

echo '<li><a href="logout.php">Cerrar Sesión</a></li>';
