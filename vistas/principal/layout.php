<?php
session_start();
$con = db::obtenerConexion();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Autoescuela</title>
    <link rel="stylesheet" href="./css/cssIndex.css">
    
</head>

<body>
    <?php
        require_once 'header.php';
    ?>
    <section>
        
        <?php
           require_once 'enruta.php';
        ?>
        </div>
    </section>

    <?php
        require_once 'footer.php';
    ?>

</body>

</html>