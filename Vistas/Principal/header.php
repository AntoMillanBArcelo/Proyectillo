<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="css/styleHeader.css">
    <link rel="stylesheet" href="css/cssIndex.css">
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="?menu=inicio">INICIO</a></li>
                <li><a href="?menu=login">INICIAR SESIÓN</a></li>
                <li><a href="?menu=cerrarsesion.php">Cerrar sesión</a></li>
                <?= Sesion::existe('login')?"Hola bienvenido ".Sesion::leer('login').
                    "<a href='?menu=cerrarsesion'>Cerrar sesión</a>":""; ?>
            </ul>         
        </nav>
    </header>
</body>
</html>
