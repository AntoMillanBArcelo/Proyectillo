<?php
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
    <link rel="stylesheet" href="css/styleRegistro.css">
</head>
<body>
    <div class="containerr">
        <div class="left"></div>
        <div class="right">
            <h1>REGISTRO</h1>
            <form method="post" action="">
                <label for="correo">Correo Electrónico:</label><br>
                <input type="email" id="correo" name="correo" maxlength="50" required><br>
                <label for="contrasena">Contraseña:</label><br>
                <input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>
                <p>¿Ya tienes una cuenta? <a href="?menu=login">Iniciar Sesión</a></p>
                <input type="submit" value="Registrarse" name="Registrarse">
            </form>
        </div>
    </div>
</body>
</html>
