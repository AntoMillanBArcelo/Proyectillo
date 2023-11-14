<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./css/styleMenuFooter.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><img src="./img/Udrive_Logo1.png" alt="logo" class="logo"></li>
            <li><a href="?menu=inicio">INICIO</a></li>         
              
            <?php 
            if (isset($_SESSION['user'])) 
            {
                if ($_SESSION['user']->getRol() === 'admin'||$_SESSION['user']->getRol() === 'profesor'||$_SESSION['user']->getRol() === 'alumno') 
                {
                    echo '<li><a href="?menu=examen">EXÁMENES</a></li>';
                }
                if ($_SESSION['user']->getRol() === 'admin') 
                {
                    echo '<li><a href="?menu=menuAdmin">ADMINISTRACIÓN</a></li>';
                }
                if ($_SESSION['user']->getRol() === 'profesor') 
                {
                    echo '<li><a href="?menu=crudExamenes">ADMINISTRACIÓN</a></li>';
                }
                if ($_SESSION['user']->getRol() === 'alumno') 
                {
                    echo '<li><a href="?menu=alumno">' . $_SESSION['user']->getCorreo() . '</a></li>';
                }
                echo '<li><a href="?menu=cerrarsesion">CERRAR SESIÓN</a></li>';
            }
            else 
            {
                echo ' <li><a href="?menu=login">INICIAR SESIÓN</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
</body>
</html>
