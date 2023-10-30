<?php
include 'metodos/metodoPintaFormulario.php';
include 'clases/Usuario.php';
include 'repositorio/repoUsuario.php';
include 'db/db.php';
$con = db::obtenerConexion();
crearFormularioLogin();
session_start();


if (isset($_POST['IniciarSesion'])) 
{
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasenaEncript = md5($contrasena);

     // Validar las credenciales en la base de datos
     $stmt = $con->prepare("SELECT * FROM usuario WHERE correo = :correo AND contrasena = :contrasena");
     $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
     $stmt->bindParam(':contrasena', $contrasenaEncript, PDO::PARAM_STR);
     $stmt->execute();
     $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
 
     if ($usuario && $contrasenaEncript) 
     {
        $_SESSION['correo'] = $correo;
        header('Location: index.php');
     } 
     else 
     {
        echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
     }
}

 

