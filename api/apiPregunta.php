<?php
include '../cargador/Autocargador.php';
$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'antonio', 'root');
$repoPregunta = new repoPregunta($con);

//MOSTRAR
if ($_SERVER["REQUEST_METHOD"]=="GET")
{
    $id=$_GET["id"];
    $pregunta=$repoPregunta->getById($id);

    if ($pregunta) {
        $preguntaApi= new stdClass();
        $preguntaApi->id=$id;
        $preguntaApi->enunciado=$pregunta->getEnunciado();
        $preguntaApi->respuesta1=$pregunta->getRespuesta1();
        $preguntaApi->respuesta2=$pregunta->getRespuesta2();
        $preguntaApi->respuesta3=$pregunta->getRespuesta3();
        $preguntaApi->correcta=$pregunta->getCorrecta();
        $preguntaApi->url=$pregunta->getUrl();
        $preguntaApi->tipoUrl=$pregunta->getTipoUrl();
        echo json_encode($preguntaApi);
    } else {
        echo json_encode(["error" => "Pregunta no encontrada"]);
    }
}

//ACTUALIZA
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $cuerpo = file_get_contents("php://input");
    $id = $_GET["id"];

    $preguntaData = json_decode($cuerpo);    
    $pregunta = new pregunta($preguntaData->fechaIni);
    $pregunta->setFechaIni($preguntaData->fechaIni);
    $result = $repoPregunta->update($id, $pregunta);

    if ($result) {
        echo "pregunta actualizado correctamente";
        http_response_code(200); // OK
    } else {
        echo "Error al actualizar el pregunta";
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
            echo "Error: ID de pregunta no válido";
            http_response_code(400); // Bad Request
            exit;
        }
    
        // Llamada al método delete en el repoPregunta
        $result = $repoPregunta->delete($id);
    
        if ($result) {
            echo "pregunta eliminado correctamente";
            http_response_code(204); // No Content
        } else {
            echo "Error al eliminar el pregunta";
            http_response_code(500); // Internal Server Error
        }
    }
    
}
//AÑADE
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $cuerpo = file_get_contents("php://input");
    $preguntaData = json_decode($cuerpo);

    if (!$preguntaData || !property_exists($preguntaData, 'fechaIni')) {
        // Manejar el caso en que los datos no son válidos
        echo "Error: Datos de pregunta no válidos";
        http_response_code(400); // Bad Request
        exit;
    }

    $pregunta = new pregunta($preguntaData->fechaIni);
    $result = $repoPregunta->insert($pregunta);

    if ($result) {
        echo "pregunta agregado correctamente";
        http_response_code(201); // Created
    } else {
        echo "Error al agregar el pregunta";
        http_response_code(500); // Internal Server Error
    }
}
?>