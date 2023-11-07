<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cargador/Autocargador.php';
$con = db::obtenerConexion();
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
         $user = new Usuario($usuario['correo'], $usuario['contrasena'], $usuario['rol']);
         $_SESSION['user'] = $user;
         header('Location: inicio.php');
      } 
      else 
      {
         echo "<p class='error'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
      }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inicia sesión</title>
   <link rel="stylesheet" type="text/css" href="css/styleIndex.css">
</head>
<body>
   <div class="container">
       <div class="left"></div>
       <div class="right">
           <h1>INICIAR SESIÓN</h1>
           <form method="post" action="">
               <label for="correo">Correo Electrónico:</label><br>
               <input type="text" id="correo" name="correo" maxlength="50" required><br>
               <label for="contrasena">Contraseña:</label><br>
               <input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>
               <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
               <input type="submit" value="Iniciar Sesión" name="IniciarSesion">
           </form>
       </div>
   </div>
</body>
</html>
