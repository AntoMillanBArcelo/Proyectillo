<?php
include 'metodos/metodoPintaFormulario.php';
include 'clases/Usuario.php';
include 'repositorio/repoUsuario.php';
include 'db/db.php';
$con = db::obtenerConexion();
crearFormularioRegistro();

if (isset($_POST['Registrarse'])) 
{
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    
    $rUsuario = new repoUsuario($con);
    $rUsuario->insert($correo, $contrasena);
}
else 
{
    echo 'error';
}