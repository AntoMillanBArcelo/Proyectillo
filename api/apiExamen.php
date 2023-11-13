<?php
include '../cargador/Autocargador.php';
$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'antonio', 'root');
$repoExamen = new repoExamen($con);

//MOSTRAR
if ($_SERVER["REQUEST_METHOD"]=="GET")
{
    $id=$_GET["id"];
    $examen=$repoExamen->getById($id);
    $examenApi= new stdClass();
    $examenApi->id=$id;
    $examenApi->fechaIni=$examen->getFechaIni();
    echo json_encode($examenApi);
}

//ACTUALIZA
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $cuerpo = file_get_contents("php://input");
    $id = $_GET["id"];

    $examenData = json_decode($cuerpo);    
    $examen = new Examen($examenData->fechaIni);
    $examen->setFechaIni($examenData->fechaIni);
    $result = $repoExamen->update($id, $examen);

    if ($result) {
        echo "Examen actualizado correctamente";
        http_response_code(200); // OK
    } else {
        echo "Error al actualizar el examen";
        http_response_code(500); // Internal Server Error
    }
}



//BORRA
if ($_SERVER["REQUEST_METHOD"]=="DELETE"){
    if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
        $id = $_GET["id"];
        
        // Verificar si el ID es válido
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            // Manejar el caso en que el ID no sea válido
            echo "Error: ID de examen no válido";
            http_response_code(400); // Bad Request
            exit;
        }
    
        // Llamada al método delete en el repoExamen
        $result = $repoExamen->delete($id);
    
        if ($result) {
            echo "Examen eliminado correctamente";
            http_response_code(204); // No Content
        } else {
            echo "Error al eliminar el examen";
            http_response_code(500); // Internal Server Error
        }
    }
    
}
//AÑADE
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $cuerpo = file_get_contents("php://input");
    $examenData = json_decode($cuerpo);

    if (!$examenData || !property_exists($examenData, 'fechaIni')) {
        // Manejar el caso en que los datos no son válidos
        echo "Error: Datos de examen no válidos";
        http_response_code(400); // Bad Request
        exit;
    }

    $examen = new Examen($examenData->fechaIni);
    $result = $repoExamen->insert($examen);

    if ($result) {
        echo "Examen agregado correctamente";
        http_response_code(201); // Created
    } else {
        echo "Error al agregar el examen";
        http_response_code(500); // Internal Server Error
    }
}

 

?>