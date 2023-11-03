<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AUTOESCUELA</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php
        require_once './Vistas/Principal/header.php';
    ?>
    <section>
        <div id="cuerpo">
        <video id="video-background" autoplay="autoplay" muted="muted" loop="loop">
            <source src="img/Forza_Net_Splash_Page_Motorsport_adb7e0d56b.mp4" type="video/mp4">
        </video>
        <h1>NOS VEMOS EN LA <br>LÍNEA DE SALIDA</h1> 
        <?php
           require_once './Vistas/Principal/enruta.php';
        ?>
        </div>
    </section>

    <?php
        require_once './Vistas/Principal/footer.php';
    ?>

</body>
</html>