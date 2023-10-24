<?php
include 'metodos/metodoPintaFormulario.php';
include 'entidades/usuario.php';
include 'repositorio/repoUsuario.php';
include 'db/db.php';
$con = db::obtenerConexion();
crearFormularioLogin();
session_start();

if (isset($_POST['Iniciar Sesión'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    
    // Validar el inicio de sesión
    $rUsuario = new repoUsuario($con); // $con es tu conexión a la base de datos
    $usuario = $rUsuario->getByCorreo($correo);

    if ($usuario) {
        // Verificar la contraseña
        if (md5($contrasena) == $usuario['contrasena']) {
            // Iniciar sesión
            $_SESSION['usuario'] = $usuario;
            header('Location: index.php'); // Redirige a la página de inicio
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Correo no encontrado";
    }
}



