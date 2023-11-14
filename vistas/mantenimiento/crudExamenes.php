<?php

if( $_SESSION['user']->getRol()!= 'admin' && $_SESSION['user']->getRol()!= 'profesor')
{
    header("Location: ?menu=inicio");
} 

if (isset($_POST['create'])) 
{
    $enunciado = $_POST['enunciado'];
    $opcion1 = $_POST['opcion1'];
    $opcion2 = $_POST['opcion2'];
    $opcion3 = $_POST['opcion3'];
    $correcta = $_POST['correcta'];
    $url = ''; 

    if (isset($_FILES['url']) && $_FILES['url']['error'] === UPLOAD_ERR_OK) 
    {
        $target_dir = "uploads/"; // Directorio donde se almacenarán las fotos
        $target_file = $target_dir . basename($_FILES["url"]["name"]);
        
        // Mueve el archivo desde el directorio temporal al directorio de destino
        if (move_uploaded_file($_FILES["url"]["tmp_name"], $target_file)) 
        {
            $url = $target_file;
        } 
        else 
        {
            echo "Error al subir la foto.";
            // Puedes agregar más lógica aquí para manejar el error de carga
        }
    }

    // Insertar datos en la base de datos
    $stmt = $con->prepare("INSERT INTO pregunta (enunciado, respuesta1, respuesta2, respuesta3, correcta, url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$enunciado, $opcion1, $opcion2, $opcion3, $correcta, $url]);
}

$preguntas = $con->query("SELECT * FROM pregunta;")->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='user'>";
echo "<tr>
        <th>Enunciado</th>
        <th>Respuesta 1</th>
        <th>Respuesta 2</th>
        <th>Respuesta 3</th>
        <th>Correcta</th>
        <th>Acciones</th>
        </tr>";
foreach ($preguntas as $pregunta) 
{
    echo "<tr>";
    echo "<td>" . $pregunta['enunciado'] . "</td>";
    echo "<td>" . $pregunta['respuesta1'] . "</td>";
    echo "<td>" . $pregunta['respuesta2'] . "</td>";
    echo "<td>" . $pregunta['respuesta3'] . "</td>";
    echo "<td>" . $pregunta['correcta'] . "</td>";
    echo "<td>
            <form method='POST'>
                <input type='hidden' name='delete_id' value='" . $pregunta['id'] . "'>
                <button type='submit' name='delete_submit'>Eliminar</button>
            </form>
          </td>";
    echo "</tr>";
}
echo '</table>';

if (isset($_POST['delete_submit'])) {
    $id = $_POST['delete_id'];
    $stmt = $con->prepare("DELETE FROM pregunta WHERE id = ?");
    $stmt->execute([$id]);    
}





if (isset($_POST['update'])) {
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
<form method="POST" enctype="multipart/form-data">>
    <input type="text" name="enunciado" placeholder="Enunciado">
    <input type="text" name="opcion1" placeholder="Opción 1">
    <input type="text" name="opcion2" placeholder="Opción 2">
    <input type="text" name="opcion3" placeholder="Opción 3">
    <select name="correcta">
        <option value="1" selected>1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <input type="file" name="url" id="foto" accept="image/*">
    <button type="submit" name="create">Crear pregunta</button>
</form>

<form method="POST">
    <input type="text" name="id" placeholder="ID a Editar">
    <input type="text" name="correo" placeholder="Nuevo correo">
    <input type="text" name="rol" placeholder="rol">
    <button type="submit" name="update">Editar Usuario</button>
</form>

</body>
</html>

