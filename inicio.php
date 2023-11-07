<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cargador/Autocargador.php';
$con = db::obtenerConexion();
session_start();

// Corrige los enlaces del menú
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoescuela</title>
    <link rel="stylesheet" href="css/styleMenuFooter.css">
    <link rel="stylesheet" href="css/cssIndex.css">
    
</head>
<body>
    <video id="video-background" autoplay="autoplay" muted="muted" loop="loop">
        <source src="img/Forza_Net_Splash_Page_Motorsport_adb7e0d56b.mp4" type="video/mp4">       
    </video>

    <nav>
        <ul>
            <li><img src="img/Udrive_Logo1.png" alt="" class="logo"></li>
            <li><a href="inicio.php">INICIO</a></li>         
            <?php if ($_SESSION['user']->getRol() === 'admin'||$_SESSION['user']->getRol() === 'profesor') 
            {
                echo '<li><a href="plantilla/examen.html">EXÁMENES</a></li>';
            }?>
            <?php if ($_SESSION['user']->getRol() === 'admin') 
            {
                echo '<li><a href="menuAdmin.php">ADMINISTRACIÓN</a></li>';
            }?>
            <li><a href="logout.php">CERRAR SESIÓN</a></li>
        </ul>
    </nav>
  
    <h1>NOS VEMOS EN LA <br>LÍNEA DE SALIDA</h1> 
    
    <footer>© 2023 Antonio Millán</footer>
</body>  
</html>


