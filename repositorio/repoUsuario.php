<?php
    include 'db.php';
    $con = db::obtenerConexion();

    /* $insert = $con-> query("INSERT INTO producto (id, nombre) VALUES (3, 'piña')");
    print "<p>Se han borrado $insert registros.</p>";
    */
    
    $resultado = $con->query("SELECT * FROM producto");
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) 
    {
        echo "Producto: " . $registro['Nombre'] . " ID: ". $registro['ID']." <br />";
    } 
 