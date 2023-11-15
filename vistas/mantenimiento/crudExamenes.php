<?php

if( $_SESSION['user']->getRol()!= 'admin' && $_SESSION['user']->getRol()!= 'profesor')
{
    header("Location: ?menu=inicio");
} 

/* -------------------------Examen---------------------------------*/
if (isset($_POST['createExamen'])) 
{
    $fechaIni = $_POST['fechaIni'];
    
    // Crear el examen
    $stmt = $con->prepare("INSERT INTO examen (fechaIni) VALUES (?)");
    $stmt->execute([$fechaIni]);

    // Obtener el ID del examen recién creado
    $examenId = $con->lastInsertId();

    // Asignar preguntas seleccionadas al nuevo examen
    if (!empty($_POST['preguntasSeleccionadas'])) {
        $preguntasSeleccionadas = $_POST['preguntasSeleccionadas'];
        
        foreach ($preguntasSeleccionadas as $preguntaId) {
            $stmt = $con->prepare("INSERT INTO examen_pregunta (examen_id, pregunta_id) VALUES (?, ?)");
            $stmt->execute([$examenId, $preguntaId]);
        }
    }
}

$examenes = $con->query("SELECT * FROM examen;")->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='user'>";
echo "<tr>
        <th>ID</th>
        <th>Fecha de Inicio</th>
        <th>Preguntas</th>
        <th>Acciones</th>
        </tr>";
foreach ($examenes as $examen) 
{
    echo "<tr>";
    echo "<td>" . $examen['id'] . "</td>";
    echo "<td>" . $examen['fechaIni'] . "</td>";

    // Obtener las preguntas asociadas a este examen
    $preguntasAsociadas = $con->prepare("SELECT p.id, p.enunciado FROM pregunta p
                                        JOIN examen_pregunta pe ON p.id = pe.pregunta_id
                                        WHERE pe.examen_id = ?");
    $preguntasAsociadas->execute([$examen['id']]);
    $preguntas = $preguntasAsociadas->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar las preguntas en una lista
    echo "<td>";
    foreach ($preguntas as $pregunta) {
        echo $pregunta['enunciado'] . "<br>";
    }
    echo "</td>";

    echo "<td>
            <form method='POST'>
                <input type='hidden' name='examenBorrar' value='" . $examen['id'] . "'>
                <button type='submit' name='borra'>Eliminar</button>
            </form>
          </td>";
    echo "</tr>";
}
echo '</table>';

/* ----------Añade las Preguntas al Examen----------- */

// Formulario para añadir preguntas a un examen
echo "<form method='POST' id='addPreguntasForm' class='hidden-form3'>";
echo "<label for='examen_id'>Selecciona el examen:</label>";
echo "<select name='examen_id'>";
foreach ($examenes as $examen) {
    echo "<option value='" . $examen['id'] . "'>" . $examen['id'] . " - " . $examen['fechaIni'] . "</option>";
}
echo "</select>";
echo "<br>";
// Agregar tres desplegables para seleccionar preguntas
for ($i = 1; $i <= 3; $i++) {
    echo "<label for='pregunta{$i}_id'>Selecciona pregunta {$i}:</label>";
    echo "<br>";
    echo "<select name='pregunta{$i}_id'>";
    echo "<br>";
    $preguntasDisponibles = $con->query("SELECT * FROM pregunta")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($preguntasDisponibles as $pregunta)
    {
        echo "<option value='" . $pregunta['id'] . "'>" . $pregunta['enunciado'] . "</option>";
    }
    echo "</select>";
}
echo "<br>";
echo "<button type='submit' name='agregarPreguntas'>Agregar Preguntas</button>";
echo "</form>";

/* ----------Añade Examen----------- */
if (isset($_POST['agregarPreguntas'])) 
{
    $examen_id = $_POST['examen_id'];
    $pregunta1_id = $_POST['pregunta1_id'];
    $pregunta2_id = $_POST['pregunta2_id'];
    $pregunta3_id = $_POST['pregunta3_id'];

    $stmt = $con->prepare("INSERT INTO examen_pregunta (examen_id, pregunta_id) VALUES (?, ?), (?, ?), (?, ?)");
    $stmt->execute([$examen_id, $pregunta1_id, $examen_id, $pregunta2_id, $examen_id, $pregunta3_id]);

}

/* ----------Borra Examen----------- */
if (isset($_POST['borra']) && isset($_POST['examenBorrar'])) {
    $id = $_POST['examenBorrar'];

    // Eliminar registros relacionados en examen_pregunta
    $stmtDeleteExamenPregunta = $con->prepare("DELETE FROM examen_pregunta WHERE examen_id = ?");
    $stmtDeleteExamenPregunta->execute([$id]);

    // Luego eliminar el examen
    $stmtDeleteExamen = $con->prepare("DELETE FROM examen WHERE id = ?");
    $stmtDeleteExamen->execute([$id]);
}


/* ----------Actualiza Examen----------- */
if (isset($_POST['updateExamen'])) 
{
    $id = $_POST['id'];
    $fechaIni = $_POST['fechaIni'];

    $stmt = $con->prepare("UPDATE `examen` SET `fechaIni` = ? WHERE `examen`.`id` = ?");
    $stmt->execute([$fechaIni, $id]);
    header("location: ?menu=crudExamenes");
}

/* -------------------------Preguntas---------------------------------*/

/* ----------Crear Preguntas----------- */
if (isset($_POST['create'])) 
{
    $enunciado = $_POST['enunciado'];
    $opcion1 = $_POST['opcion1'];
    $opcion2 = $_POST['opcion2'];
    $opcion3 = $_POST['opcion3'];
    $correcta = $_POST['correcta'];
    $url = ''; 

    //Verifica si se ha enviado un archivo a través de un formulario
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

    $stmt = $con->prepare("INSERT INTO pregunta (enunciado, respuesta1, respuesta2, respuesta3, correcta, url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$enunciado, $opcion1, $opcion2, $opcion3, $correcta, $url]);
}


/* ----------Mostrar Todas las Preguntas----------- */
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

/* ----------Borra Preguntas----------- */
if (isset($_POST['borra']) && isset($_POST['preguntaBorrar'])) 
{
    $id = $_POST['preguntaBorrar'];
    $stmt = $con->prepare("DELETE FROM pregunta WHERE id = ?");
    $stmt->execute([$id]);    
}

/* ----------Actualiza Preguntas----------- */
if (isset($_POST['updatePregunta'])) 
{
    $url = isset($_POST['url']) ? $_POST['url'] : '';

    $id = $_POST['id'];
    $enunciado = $_POST['enunciado'];
    $respuesta1 = $_POST['respuesta1'];
    $respuesta2 = $_POST['respuesta2'];
    $respuesta3 = $_POST['respuesta3'];
    $correcta = $_POST['correcta'];
    $tipoUrl = $_POST['tipoUrl'];

    $stmt = $con->prepare("UPDATE `pregunta` 
    SET `enunciado` = ?, `respuesta1` = ?, `respuesta2` = ?, `respuesta3` = ?, `correcta` = ?, `url` = ?, `tipoUrl` = ? 
    WHERE `pregunta`.`id` = ?");
     
    $stmt->execute([$enunciado, $respuesta1, $respuesta2, $respuesta3, $correcta, $url, $tipoUrl, $id]);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./css/styleCRUD.css">
</head>
<body>
    <div class="body">
    <!-- Select de Administracion de Examenes -->
        <select id="formSelector2">
            <option value="showCreate2">Mostrar Crear Examen</option>
            <option value="showEdit2">Mostrar Editar Examen</option>
            <option value="hideForm2">Ocultar Formulario</option>
        </select>

        <!-- Formulario que crea examenes -->
        <form method="POST" id="createForm2" class="hidden-form2">
            <label for="fechaIni">Fecha de Inicio:</label>
            <input type="date" name="fechaIni">
            <br>
            <button type="submit" name="createExamen">Crear examen</button>
        </form>
        <!-- Formulario que edita examenes -->
        <form method="POST" id="editForm2" class="hidden-form2">
            <input type="text" name="id" placeholder="ID a Editar">
            <label for="fechaIni">Nueva Fecha de Inicio:</label>
            <input type="date" name="fechaIni">
            <br>
            <button type="submit" name="updateExamen">Editar Examen</button>
        </form>

        
    <!-- Select de Administracion de Preguntas -->
        <select id="formSelector">
            <option value="showCreate">Mostrar Crear Pregunta</option>
            <option value="showEdit">Mostrar Editar Pregunta</option>
            <option value="hideForm">Ocultar Formulario</option>
        </select>

        <!-- Formulario que crea preguntas -->
        <form method="POST" enctype="multipart/form-data" id="createForm" class="hidden-form">
            <input type="text" name="enunciado" placeholder="Enunciado">
            <input type="text" name="opcion1" placeholder="Opción 1">
            <input type="text" name="opcion2" placeholder="Opción 2">
            <input type="text" name="opcion3" placeholder="Opción 3">
            <br>
            <p>Selecciona la opción correcta</p>
            <br>
            <input type="file" name="url" id="foto" accept="image/*">
            <br>
            <button type="submit" name="create">Crear pregunta</button>
        </form>

        <!-- Formulario que crea preguntas -->
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
            <button type="submit" name="updatePregunta">Editar Pregunta</button>
        </form>
        
        <select id="formSelector3">
            <option value="showCreate3">Mostrar Añadir Preguntas</option>
            <option value="hideForm3">Ocultar Formulario</option>
        </select>

        <!-- JavaScript que permite ocultar y mostrar formularios -->
        <script>
            document.getElementById('formSelector').addEventListener('change', function () 
            {
            var createForm = document.getElementById('createForm');
            var editForm = document.getElementById('editForm');

            if (this.value === 'showCreate') {
                createForm.classList.remove('hidden-form');
                editForm.classList.add('hidden-form');
            } else if (this.value === 'showEdit') {
                createForm.classList.add('hidden-form');
                editForm.classList.remove('hidden-form');
            } else {
                createForm.classList.add('hidden-form');
                editForm.classList.add('hidden-form');
            }
        });

        document.getElementById('formSelector2').addEventListener('change', function () 
        {
            var createForm2 = document.getElementById('createForm2');
            var editForm2 = document.getElementById('editForm2');

            if (this.value === 'showCreate2') {
                createForm2.classList.remove('hidden-form2');
                editForm2.classList.add('hidden-form2');
            } else if (this.value === 'showEdit2') {
                createForm2.classList.add('hidden-form2');
                editForm2.classList.remove('hidden-form2');
            } else {
                createForm2.classList.add('hidden-form2');
                editForm2.classList.add('hidden-form2');
            }
        });

        document.getElementById('formSelector3').addEventListener('change', function () {
                var addPreguntasForm = document.getElementById('addPreguntasForm');

                if (this.value === 'showCreate3') {
                    addPreguntasForm.classList.remove('hidden-form3');
                } else {
                    addPreguntasForm.classList.add('hidden-form3');
                }
            });
        </script>
    </div>
</body>
</html>

