<?php
$con = db::obtenerConexion();

if( $_SESSION['user']->getRol()!= 'admin')
{
    header("Location: ?menu=inicio");
} 

if (isset($_POST['create'])) 
{
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $stmt = $con->prepare("INSERT INTO usuario (correo, contrasena, rol) VALUES (?, ?, ?)");
    $stmt->execute([$correo, $contrasena, $rol]);
}

$usuarios = $con->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='user'>";
echo "<tr>
        <th>ID</th>
        <th>Correo</th>
        <th>Contraseña</th>
        <th>Rol</th>
        <th>Acciones</th>
        </tr>";

foreach ($usuarios as $usuario) 
{
    // Agregar una clase específica si el usuario no tiene rol
    $rowClass = empty($usuario['rol']) ? 'sin-rol' : '';

    echo "<tr class='$rowClass'>";
    echo "<td>" . $usuario['id'] . "</td>";
    echo "<td>" . $usuario['correo'] . "</td>";
    echo "<td>" . $usuario['contrasena'] . "</td>";
    echo "<td>" . $usuario['rol'] . "</td>";
    echo "<td>
            <form method='POST'>
                <input type='hidden' name='usuarioBorrar' value='" . $usuario['id'] . "'>
                <button type='submit' name='borrar'>Eliminar</button>
            </form>
        </td>";
    echo "</tr>";
}

echo '</table>';

if (isset($_POST['borrar'])) 
{
    $id = $_POST['usuarioBorrar'];
    $stmt = $con->prepare("DELETE FROM usuario WHERE id = ?");
    $stmt->execute([$id]);    
}

if (isset($_POST['update'])) 
{
    $id = $_POST['id'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $stmt = $con->prepare("UPDATE usuario SET correo = ?, rol = ? WHERE id = ?");
    $stmt->execute([$correo, $rol, $id]);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./css/styleCRUD.css">
</head>
<body>
<div class="body">
    <select id="formSelector">
        <option value="showCreate">Mostrar Crear Usuario</option>
        <option value="showEdit">Mostrar Editar Usuario</option>
        <option value="hideForms">Ocultar Formularios</option>
    </select>

        <form method="POST" enctype="multipart/form-data" id="createForm" class="hidden-form">
        <label for="correo">Correo:</label>
        <input type="text" name="correo" placeholder="Correo">
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Contraseña">
        <br>
        <label for="rol">Seleccione el rol:</label>
        <br>
        <select name="rol">
            <option value="admin">Admin</option>
            <option value="profesor">Profesor</option>
            <option value="alumno">Alumno</option>
        </select>
        <br>
        <button type="submit" name="create">Crear Usuario</button>
    </form>

    <form method="POST" id="editForm" class="hidden-form">
        <label for="id">Seleccione el usuario a editar:</label>
        <br>
        <select name="id">
            <?php
                foreach ($usuarios as $usuario) {
                    echo "<option value='" . $usuario['id'] . "'>" . $usuario['id'] . "</option>";
                }
            ?>
        </select>
        <br>
        <label for="correo">Nuevo correo:</label>
        <br>
        <input type="text" name="correo" placeholder="Nuevo correo">
        <br>
        <label for="rol">Seleccione el rol:</label>
        <br>
        <select name="rol">
            <option value="admin">Admin</option>
            <option value="profesor">Profesor</option>
            <option value="alumno">Alumno</option>
        </select>
        <br>
        <button type="submit" name="update">Editar Usuario</button>
    </form>

    <script>
        document.getElementById('formSelector').addEventListener('change', function () {
            var createForm = document.getElementById('createForm');
            var editForm = document.getElementById('editForm');

            if (this.value === 'showCreate') {
                createForm.style.display = 'block';
                editForm.style.display = 'none';
            } else if (this.value === 'showEdit') {
                createForm.style.display = 'none';
                editForm.style.display = 'block';
            } else if (this.value === 'hideForms') {
                createForm.style.display = 'none';
                editForm.style.display = 'none';
            }
        });
    </script>
</div>
</body>
</html>
