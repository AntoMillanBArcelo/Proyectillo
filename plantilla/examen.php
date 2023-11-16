<?php
if (isset($_SESSION['user']) && ($_SESSION['user']->getRol() == 'admin' || $_SESSION['user']->getRol() == 'profesor')) 
{

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["asignarExamen"])) 
    {
        $idUsuario = $_POST["idUsuario"];
        $idExamen = $_POST["idExamen"];

        $stmtVerificar = $con->prepare("SELECT * FROM usuario_examen WHERE id_usuario = ? AND id_examen = ?");
        $stmtVerificar->execute([$idUsuario, $idExamen]);

        if ($stmtVerificar->rowCount() > 0) 
        {
            echo "El usuario ya tiene asignado este examen.";
        } 
        else 
        {
            $stmtAsignar = $con->prepare("INSERT INTO usuario_examen (id_usuario, id_examen, estado) VALUES (?, ?, 'asignado')");
            $stmtAsignar->execute([$idUsuario, $idExamen]);

            echo "Examen asignado exitosamente al usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen</title>
    <script src="js/autoescuela.js"></script>
    <link rel="stylesheet" href="diseño/diseñoPregunta.css">
</head>
<body>
    <div class="body">
        <div id="examen"></div>
        <button id="comenzar" class="bnt">Comenzar</button>
    </div>

    <?php
        if (isset($_SESSION['user']) && ($_SESSION['user']->getRol() == 'admin' || $_SESSION['user']->getRol() == 'profesor')) 
        {
    ?>

        <form method="POST">
            <label for="idUsuario">Seleccionar Usuario:</label>
            <select name="idUsuario" required>
                <?php
                    $usuarios = $con->query("SELECT id, correo FROM usuario;")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($usuarios as $usuario) 
                    {
                        echo "<option value='{$usuario['id']}'>{$usuario['correo']}</option>";
                    }
                ?>
            </select>

            <label for="idExamen">Seleccionar Examen:</label>
            <select name="idExamen" required>
                <?php
                    $examenes = $con->query("SELECT id, fechaIni FROM examen;")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($examenes as $examen) 
                    {
                        echo "<option value='{$examen['id']}'>{$examen['fechaIni']}</option>";
                    }
                ?>
            </select>

            <button type="submit" name="asignarExamen">Asignar Examen</button>
        </form>
    <?php
        /*Llave final del if*/    
        }
    ?>
</body>
</html>
