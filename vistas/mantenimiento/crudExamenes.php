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
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["url"]["name"]);
        
        if (move_uploaded_file($_FILES["url"]["tmp_name"], $target_file)) 
        {
            $url = $target_file;
        } 
        else 
        {
            echo "Error al subir la foto.";
        }
    }

    // Insertar datos en la base de datos
    $stmt = $con->prepare("INSERT INTO pregunta (enunciado, respuesta1, respuesta2, respuesta3, correcta, url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$enunciado, $opcion1, $opcion2, $opcion3, $correcta, $url]);
}

$preguntas = $con->query("SELECT * FROM pregunta;")->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='user'>";
echo "<tr>
        <th>ID</th>
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
    echo "<td>" . $pregunta['id'] . "</td>";
    echo "<td>" . $pregunta['enunciado'] . "</td>";
    echo "<td>" . $pregunta['respuesta1'] . "</td>";
    echo "<td>" . $pregunta['respuesta2'] . "</td>";
    echo "<td>" . $pregunta['respuesta3'] . "</td>";
    echo "<td>" . $pregunta['correcta'] . "</td>";
    echo "<td>
            <form method='POST'>
                <input type='hidden' name='preguntaBorrar' value='" . $pregunta['id'] . "'>
                <button type='submit' name='borra'>Eliminar</button>
            </form>
          </td>";
    echo "</tr>";
}
echo '</table>';

if (isset($_POST['borra'])) 
{
    $id = $_POST['preguntaBorrar'];
    $stmt = $con->prepare("DELETE FROM pregunta WHERE id = ?");
    $stmt->execute([$id]);    
}

if (isset($_POST['update'])) 
{
    $id = $_POST['id'];
    $enunciado = $_POST['enunciado'];
    $respuesta1 = $_POST['respuesta1'];
    $respuesta2 = $_POST['respuesta2'];
    $respuesta3 = $_POST['respuesta3'];
    $correcta = $_POST['correcta'];
    $url = $_POST['url'];
    $tipoUrl = $_POST['tipoUrl'];

    $stmt = $con->prepare("UPDATE `pregunta` 
    SET `enunciado` = ?, `respuesta1` = ?, `respuesta2` = ?, `respuesta3` = ?, `correcta` = ?, `url` = ?, `tipoUrl` = ? 
    WHERE `pregunta`.`id` = ?");
     
     $stmt->execute([$enunciado, $respuesta1, $respuesta2, $respuesta3, $correcta, $url, $tipoUrl, $id]);
     header("location: ?menu=crudExamenes");
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
            <option value="showCreate">Mostrar Crear Pregunta</option>
            <option value="showEdit">Mostrar Editar Pregunta</option>
        </select>

        <form method="POST" enctype="multipart/form-data" id="createForm" class="hidden-form">
            <input type="text" name="enunciado" placeholder="Enunciado">
            <input type="text" name="opcion1" placeholder="Opción 1">
            <input type="text" name="opcion2" placeholder="Opción 2">
            <input type="text" name="opcion3" placeholder="Opción 3">
            <br>
            <p>Selecciona la opción correcta</p>
            <br>
            <select name="correcta">
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            <br>
            <input type="file" name="url" id="foto" accept="image/*">
            <br>
            <button type="submit" name="create">Crear pregunta</button>
        </form>

        <form method="POST" id="editForm" class="hidden-form">
            <input type="text" name="id" placeholder="ID a Editar">
            <input type="text" name="enunciado" placeholder="Nuevo enunciado">
            <input type="text" name="respuesta1" placeholder="respuesta1">
            <input type="text" name="respuesta2" placeholder="respuesta2">
            <input type="text" name="respuesta3" placeholder="respuesta3">
            <br>
            <label for="correcta">Seleccione la respuesta correcta:</label>
            <br>
            <select name="correcta">
                <option value="1">Opción 1</option>
                <option value="2">Opción 2</option>
                <option value="3">Opción 3</option>
            </select>
            <br>
            <label for="tipoUrl">Seleccione el tipo de URL:</label>
            <br>
            <select name="tipoUrl">
                <option value="imagen">Imagen</option>
                <option value="video">Video</option>
            </select>
            <br>
            <button type="submit" name="update">Editar Usuario</button>
        </form>


        <script>
            document.getElementById('formSelector').addEventListener('change', function () {
                var createForm = document.getElementById('createForm');
                var editForm = document.getElementById('editForm');

                if (this.value === 'showCreate') {
                    createForm.classList.remove('hidden-form');
                    editForm.classList.add('hidden-form');
                } else if (this.value === 'showEdit') {
                    createForm.classList.add('hidden-form');
                    editForm.classList.remove('hidden-form');
                }
            });
        </script>
    </div>
</body>
</html>

