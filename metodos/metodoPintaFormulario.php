<?php
    function crearFormularioRegistro() 
    {
        echo '<h2>Registro</h2>';
        echo '<form method="post" action="">';
        echo '<label for="correo">Correo Electrónico:</label><br>';
        echo '<input type="email" id="correo" name="correo" maxlength="50" required><br>';
        echo '<label for="contrasena">Contraseña:</label><br>';
        echo '<input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>';
        echo '<input type="submit" value="Registrarse" name="Registrarse">';
        echo '</form>';

        echo '<p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>';
    }


function crearFormularioLogin() 
    {
        echo '<form method="post" action="">';
        echo '<label for="correo">Correo Electrónico:</label><br>';
        echo '<input type="email" id="correo" name="correo" maxlength="50" required><br>';
        echo '<label for="contrasena">Contraseña:</label><br>';
        echo '<input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>';
        echo '<input type="submit" value="Iniciar Sesión">';
        echo '</form>';

        echo '<p>¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>';
    }
?>
