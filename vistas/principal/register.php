<?php
$con = db::obtenerConexion();

if (isset($_POST['Registrarse'])) 
{
    $val = new Validacion;
    $correo = $_POST['correo'];

    // Validar el correo electrónico y la longitud de la contraseña
    if ($val->Email('correo') && $val->CadenaRango('contrasena', 20, 6)) 
    {
        $contrasena = $_POST['contrasena'];
        $rUsuario = new repoUsuario($con);
        $rUsuario->insertRegister($correo, $contrasena);
        header('Location: ?menu=login');
        exit();
    } 
    else 
    {
        // Mostrar mensaje de error correspondiente
        if (!$val->Email('correo')) 
        {
            echo "<p class='error'>El correo no es válido. Por favor, introduce uno válido.</p>";
        } 
        elseif (!$val->CadenaRango('contrasena', 20, 6)) 
        {
            echo "<p class='error'>La contraseña debe tener entre 7 y 20 caracteres.</p>";
        }
    }
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
