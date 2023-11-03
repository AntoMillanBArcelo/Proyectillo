<?php
include_once 'metodos/MetodoPintaMenu.php';
include_once 'db/db.php';
include 'clases/Usuario.php';
// Llama a la función crearMenu de la clase MetodoPintaMenu para generar el menú.
$con = db::obtenerConexion();
session_start();

// Corrige los enlaces del menú
echo '<li><a href="plantilla/examen.html">Examen</a></li>';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoescuela</title>
    <link rel="stylesheet" href="css/cssIndex.css">
</head>
<body>
    <video id="video-background" autoplay="autoplay" muted="muted" loop="loop">
        <source src="img/Forza_Net_Splash_Page_Motorsport_adb7e0d56b.mp4" type="video/mp4">       
    </video>

    <nav>
        <ul>
            <li><a href="index.html">INICIO</a></li>         
            <?php if ($_SESSION['user']->getRol() === 'admin') {
            echo '<li><a href="crudUsuario.php">ADMINISTRACIÓN</a></li>';
            }?>
            <li><a href="logout.php">CERRAR SESIÓN</a></li>
        </ul>
    </nav>
  
    <h1>NOS VEMOS EN LA <br>LÍNEA DE SALIDA</h1> 
    
    <footer>© 2023 Antonio Millán</footer>
</body>
</html>


