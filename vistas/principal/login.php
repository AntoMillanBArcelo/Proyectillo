<?php
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
         session_start();
         $user = new Usuario($usuario['correo'], $usuario['contrasena'], $usuario['rol']);
         $_SESSION['user'] = $user;
         header('Location: index.php');
      } 
      else 
      {
         echo "<p class='error'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
      }
}
?>

<head>
   <link rel="stylesheet" type="text/css" href="./css/styleLogin.css">
</head>
<body>
   <div class='body'>
   <div class="containerr">
       <div class="left"></div>
       <div class="right">
           <h1>INICIAR SESIÓN</h1>
           <form method="post" action="">
               <label for="correo">Correo Electrónico:</label><br>
               <input type="text" id="correo" name="correo" maxlength="50" required><br>
               <label for="contrasena">Contraseña:</label><br>
               <input type="password" id="contrasena" name="contrasena" maxlength="50" required><br>
               <p>¿No tienes una cuenta? <a href="?menu=register">Regístrate</a></p>
               <input type="submit" value="Iniciar Sesión" name="IniciarSesion">
           </form>
       </div>
   </div>
   </div>
</body>
</html>
