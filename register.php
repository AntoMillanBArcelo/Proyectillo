<?php
include 'metodos/metodoPintaFormulario.php';
include 'clases/Usuario.php';
include 'repositorio/repoUsuario.php';
include 'db/db.php';
$con = db::obtenerConexion();
metodoPintaFormulario::crearFormularioRegistro();

if (isset($_POST['Registrarse'])) 
{
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];
    $rUsuario = new repoUsuario($con);
    $rUsuario->insert($correo, $contrasena,$rol);
}
else 
{
    echo 'error';
}