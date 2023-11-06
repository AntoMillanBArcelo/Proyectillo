<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cargador/Autocargador.php';
$con = db::obtenerConexion();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleMenuAdmin.css">
    <link rel="stylesheet" href="css/styleMenuFooter.css">
    <title>Menú Horizontal</title>
</head>
<body>
<nav>
        <ul>
            <li><a href="inicio.php">INICIO</a></li>         
            <?php if ($_SESSION['user']->getRol() === 'admin') 
            {
            echo '<li><a href="menuAdmin.php">ADMINISTRACIÓN</a></li>';
            echo '<li><a href="plantilla/examen.html">EXÁMENES</a></li>';
            }?>
            <li><a href="logout.php">CERRAR SESIÓN</a></li>
        </ul>
    </nav>
    <div class="menu">
        <div class="card">
            <img src="usuario.jpg" alt="Usuario">
            <p><a href="crudUsuario.php">Usuario</a></p>
        </div>
        <div class="card">
            <img src="examenes.jpg" alt="Examenes">
            <p><a href="crudExamenes.php">Examenes</a></p>
        </div>
    </div>
    <footer>© 2023 Antonio Millán</footer>
</body>
</html>
