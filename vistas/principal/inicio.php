<?php
session_start();
$con = db::obtenerConexion();


if (!isset($_SESSION['user'])) 
{
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
    <video id="video-background" autoplay muted loop>
        <source src="/img/Forza_Net_Splash_Page_Motorsport_adb7e0d56b.mp4" type="video/mp4">       
    </video>
  
    <h1>NOS VEMOS EN LA <br>LÍNEA DE SALIDA</h1> 
    
    <footer>© 2023 Antonio Millán</footer>
</body>  
</html>
 

