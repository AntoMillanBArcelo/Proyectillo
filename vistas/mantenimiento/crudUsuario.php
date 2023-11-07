<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/cargador/Autocargador.php';
$con = db::obtenerConexion();

if (isset($_POST['create'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $stmt = $con->prepare("INSERT INTO usuarios (correo, contrasena, rol) VALUES (?, ?, ?)");
    $stmt->execute([$correo, $contrasena]);
}

$usuarios = $con->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {
    echo "ID: " . $usuario['id'] . "<br>";
    echo "correo: " . $usuario['correo'] . "<br>";
    echo "contrasena: " . $usuario['contrasena'] . "<br>";
    echo "rol: " . $usuario['rol'] . "<br>";
    echo "<hr>";
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $stmt = $con->prepare("UPDATE usuario SET correo = ?, rol = ? WHERE id = ?");
    $stmt->execute([$correo, $rol, $id]);
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $con->prepare("DELETE FROM usuario WHERE id = ?");
    $stmt->execute([$id]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crud</title>
    <link rel="stylesheet" href="css/styleCRUD.css">
</head>
<body>
<form method="POST">
    <input type="text" name="correo" placeholder="correo">
    <input type="contrasena" name="contrasena" placeholder="contrasena">
    <button type="submit" name="create">Crear Usuario</button>
</form>

<form method="POST">
    <input type="text" name="id" placeholder="ID a Editar">
    <input type="text" name="correo" placeholder="Nuevo correo">
    <input type="text" name="rol" placeholder="rol">
    <button type="submit" name="update">Editar Usuario</button>
</form>

<ul>
    <?php foreach ($usuarios as $usuario): ?>
        <li>
            <?php echo $usuario['correo']; ?>
            (<a href="?delete=<?php echo $usuario['id']; ?>">Eliminar</a>)
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>

