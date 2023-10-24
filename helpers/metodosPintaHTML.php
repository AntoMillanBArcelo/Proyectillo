<?php

//Pinta el formulario de inicio de sesion
function pintaFormulario()
{
    echo '<h2>Mantenimiento</h2>';
    echo '<form action="" method="post">';
        echo '<label for="id">ID:</label>';
        echo '<input type="text" name="id">';
        echo '<br><br>';
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" name="nombre">';
        echo '<br><br>';
        echo '<button type="submit" name="nuevo">Nuevo</button>';
        echo '<button type="submit" name="borrar">Borrar</button>';
        echo '<button type="submit" name="modificar">Modificar</button>';
        echo '<button type="submit" name="vertodo">Ver todo</button>';
        echo '<button type="submit" name="cerrar">Cerrar sesión</button>';
    echo '</form>';

}

//Pinta el formulario de registro
function pintaRegistro()
{
    echo '<h2>Registro</h2>';
    echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '<label for="">Nombre de usuario: </label>';
        echo '<input type="text" name="usuario">';
        echo '<br><br>';
        echo '<label for="">Contraseña</label>';
        echo '<input type="text" name="contraseña">';
        echo '<br><br>';
        echo '<label for="rol">Rol</label>';
        echo ' <select name="rol">
                <option value="admin">Admin</option>
                <option value="alumno">Alumno</option>
                <option value="profesor">Profesor</option>
                </select>';
        echo '<br><br>';
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="30000000000" />';
        echo '<label for="">Subir fichero</label>';
        echo '<input name="foto" type="file" />';
        echo '<br><br>';
        echo '<input type="submit" value="enviar" name="enviar"/>';
        
    echo '</form>';
}

//Pinta el formulario de inicar sesion
function pintaLogin()
{
    echo '<h2>Inicia sesión</h2>';
    echo '<form action="" method="post">';
        echo '<label for="">Usuario</label>';
        echo '<input type="text" name="usuario">';
        echo '<br><br>';
        echo '<label for="">Contraseña</label>';
        echo '<input type="text" name="contraseña">';
        echo '<br><br>';
        echo '<button name="enviar">Entrar</button>';
        echo '<br><br>';
        echo '<a href="registro.php">Registrate</a>';
    echo '</form>';
}
