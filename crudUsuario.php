<?php
session_start();
include 'db/db.php';
$con = db::obtenerConexion();

if (isset($_POST['create'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $stmt = $con->prepare("INSERT INTO usuarios (correo, contrasena) VALUES (?, ?)");
    $stmt->execute([$correo, $contrasena]);
}

$usuarios = $con->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {
    echo "ID: " . $usuario['id'] . "<br>";
    echo "correo: " . $usuario['correo'] . "<br>";
    echo "contrasena: " . $usuario['contrasena'] . "<br>";
    echo "<hr>";
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $stmt = $con->prepare("UPDATE usuarios SET correo = ?, contrasena = ? WHERE id = ?");
    $stmt->execute([$correo, $contrasena, $id]);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
}
?>
<form method="POST">
    <input type="text" name="correo" placeholder="correo">
    <input type="contrasena" name="contrasena" placeholder="contrasena">
    <button type="submit" name="create">Crear Usuario</button>
</form>

<form method="POST">
    <input type="text" name="id" placeholder="ID a Editar">
    <input type="text" name="correo" placeholder="Nuevo correo">
    <input type="contrasena" name="contrasena" placeholder="Nuevo contrasena">
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
