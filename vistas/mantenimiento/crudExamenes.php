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
}

/* -------------------------Preguntas---------------------------------*/



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

        <select id="formSelector3">
            <option value="showCreate3">Mostrar Añadir Preguntas</option>
            <option value="hideForm3">Ocultar Formulario</option>
        </select>

        <button class="btnPreg"><a href="?menu=pregunta">VER PREGUNTAS</a></button>

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

        <!-- JavaScript que permite ocultar y mostrar formularios -->
        <script>
        document.getElementById('formSelector2').addEventListener('change', function () 
{
    var createForm2 = document.getElementById('createForm2');
    var editForm2 = document.getElementById('editForm2');
    var addPreguntasForm = document.getElementById('addPreguntasForm');

    if (this.value === 'showCreate2') 
    {
        createForm2.classList.remove('hidden-form2');
        editForm2.classList.add('hidden-form2');
        addPreguntasForm.classList.add('show-below');
    } 
    else if (this.value === 'showEdit2') 
    {
        createForm2.classList.add('hidden-form2');
        editForm2.classList.remove('hidden-form2');
        addPreguntasForm.classList.add('show-below');
    } 
    else 
    {
        createForm2.classList.add('hidden-form2');
        editForm2.classList.add('hidden-form2');
        addPreguntasForm.classList.remove('show-below');
    }
});

document.getElementById('formSelector3').addEventListener('change', function () {
    var addPreguntasForm = document.getElementById('addPreguntasForm');

    if (this.value === 'showCreate3') 
    {
        addPreguntasForm.classList.remove('hidden-form3');
        addPreguntasForm.classList.add('show-below');
    } 
    else 
    {
        addPreguntasForm.classList.add('hidden-form3');
        addPreguntasForm.classList.remove('show-below');
    }
});

        </script>

    </div>
</body>
</html>

