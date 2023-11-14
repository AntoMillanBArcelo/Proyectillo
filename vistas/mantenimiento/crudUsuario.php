<?php
$con = db::obtenerConexion();

if (isset($_POST['create'])) 
{
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $stmt = $con->prepare("INSERT INTO usuarios (correo, contrasena, rol) VALUES (?, ?, ?)");
    $stmt->execute([$correo, $contrasena]);
}

$usuarios = $con->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='user'>";
echo "<tr>
        <th>id</th>
        <th>correo</th>
        <th>contraseña</th>
        <th>rol</th>
        <th>Acciones</th>
        </tr>";
foreach ($usuarios as $usuario) 
{
    echo "<tr>";
    echo "<td>" . $usuario['id'] . "</td>";
    echo "<td>" . $usuario['correo'] . "</td>";
    echo "<td>" . $usuario['contrasena'] . "</td>";
    echo "<td>" . $usuario['rol'] . "</td>";
    echo "<td>
    <form method='POST'>
            <input type='hidden' name='delete_id' value='" . $pregunta['id'] . "'>
            <button type='submit' name='delete_submit'>Eliminar</button>
        </form>
    </td>";
    echo "</tr>";
}
echo '</table>';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $stmt = $con->prepare("UPDATE usuario SET correo = ?, rol = ? WHERE id = ?");
    $stmt->execute([$correo, $rol, $id]);
}


if (isset($_POST['delete_submit'])) {
    $id = $_POST['delete_id'];
    $stmt = $con->prepare("DELETE FROM pregunta WHERE id = ?");
    $stmt->execute([$id]);    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./css/styleCRUD.css">
</head>
<body>
    <div class="contenedor">
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
    </div>

</body>
</html>

