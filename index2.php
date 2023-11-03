<?php
session_start();
include_once 'metodos/MetodoPintaMenu.php';
include_once 'db/db.php';
include_once 'clases/Usuario.php';

// Llama a la función crearMenu de la clase MetodoPintaMenu para generar el menú.
$con = db::obtenerConexion();

// Corrige los enlaces del menú
echo '<li><a href="plantilla/plantillaPregunta.html">Pregunta</a></li>';
echo '<li><a href="plantilla/examen.html">Examen</a></li>';
echo '<li><a href="logout.php">Cerrar Sesión</a></li>';
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
            <li><a href="index.php">Inicio</a></li>
            <?php
            try 
            {
                if (!isset($_SESSION['user'])) 
                {
                    $rol = $_SESSION['user']->getRol();
                    // El usuario ha iniciado sesión
                    if ($rol === 'admin') 
                    {
                        var_dump($_SESSION['user']);
                        // Opciones específicas para el rol de administrador
                        echo '<li><a href="crudUsuario.php">Administrar Usuarios</a></li>';
                    }
                    
                    // Opciones comunes para todos los usuarios
                    echo '<li><a href="logout.php">Cerrar Sesión</a></li>';
                } 
                else 
                {
                    // Opciones para usuarios no autenticados
                    echo '<li><a href="login.php">Iniciar sesión php</a></li>';
                }
            } 
            catch (Exception $e) 
            {
                // Manejo de errores
                echo 'Se ha producido un error: ' . $e->getMessage();
            }
            ?>
            <!-- <li><a href="login.php">Iniciar sesión</a></li> -->
            <!-- <li><a href="logout.php">Cerrar sesión</a></li> -->
        </ul>
    </nav>
  
    <h1>NOS VEMOS EN LA <br>LÍNEA DE SALIDA</h1> 
    
    <footer>© 2023 Antonio Millán</footer>
</body>
</html>
