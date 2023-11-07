<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cargador/Autocargador.php';
$con = db::obtenerConexion();

if (isset($_POST['Registrarse'])) 
{
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rUsuario = new repoUsuario($con);
    $rUsuario->insert($correo, $contrasena,);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resgistro</title>
    <link rel="stylesheet" href="css/styleRegistro.css">
</head>
<body>
    <div class="container">
    <div class="left"></div>
    <div class="right">
    <h1>Registro</h1>
    <form method="post" action="">
        <label for="correo">Correo Electrónico:</label><br>
        <input type="email" id="correo" name="correo" maxlength="50" required><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>
        <p>¿Ya tienes una cuenta? <a href="index.php">Iniciar Sesión</a></p>
        <input type="submit" value="Registrarse" name="Registrarse">
    </form>
    </div>
    </div>
    
</body>
</html>
