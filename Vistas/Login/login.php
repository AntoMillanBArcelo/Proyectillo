<?php
session_start();
include 'clases/Usuario.php';
include 'repositorio/repoUsuario.php';
include 'db/db.php';

$con = db::obtenerConexion();

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
         $user = new Usuario($usuario['correo'], $usuario['contrasena'], $usuario['rol']);
         $_SESSION['user'] = $user;
         $_SESSION['correo'] = $correo;
         header('Location: index.php');
      } 
      else 
      {
         echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="./css/styleLogin.css">
</head>
<body>
<form method="post" action="">';
         '<label for="correo">Correo Electrónico:</label><br>';
         '<input type="email" id="correo" name="correo" maxlength="50" required><br>';
         '<label for="contrasena">Contraseña:</label><br>';
         '<input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>';
         '<input type="submit" value="Iniciar Sesión" name="IniciarSesion">';
         '</form>';

         '<p>¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>';
</body>
</html>
 

