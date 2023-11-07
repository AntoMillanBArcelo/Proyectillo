<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="./css/styleMenuFooter.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><img src="./img/Udrive_Logo1.png" alt="" class="logo"></li>
            <li><a href="?menu=inicio">INICIO</a></li>         
            <li><a href="?menu=login">INICIAR SESIÓN</a></li>  
            <?php 
            if (isset($_SESSION['user'])) 
            {
                if ($_SESSION['user']->getRol() === 'admin'||$_SESSION['user']->getRol() === 'profesor') 
                {
                    echo '<li><a href="plantilla/examen.html">EXÁMENES</a></li>';
                }
                 if ($_SESSION['user']->getRol() === 'admin') 
                {
                    echo '<li><a href="?menu=menuAdmin">ADMINISTRACIÓN</a></li>';
                }
            }
            ?>
            <li><a href="?menu=cerrarsesion">CERRAR SESIÓN</a></li>
            
        </ul>
    </nav>
</header>
</body>
</html>
