<?php
include '../cargador/Autocargador.php';
$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root', '');
$repoPregunta = new repoPregunta($con);

//MOSTRAR
if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $id = $_GET["id"];
    $pregunta = $repoPregunta->getById($id);

    if ($pregunta) {
        echo json_encode($pregunta);
    } else {
        echo json_encode(["error" => "Pregunta no encontrada"]);
    }
}

//ACTUALIZA
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $cuerpo = file_get_contents("php://input");
    $id = $_GET["id"];

    $preguntaData = json_decode($cuerpo);

    $result = $repoPregunta->update($id, $preguntaData->enunciado, $preguntaData->respuesta1, $preguntaData->respuesta2, $preguntaData->respuesta3, $preguntaData->correcta, $preguntaData->url, $preguntaData->tipoUrl);

    if ($result) 
    {
        http_response_code(200); 
    } 
    else 
    {
        http_response_code(500); 
    }
}

//BORRA
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_GET["id"];
    $result = $repoPregunta->delete($id);

    if ($result) 
    {
        echo json_encode(["message" => "Pregunta eliminada correctamente"]);
        http_response_code(204); // No Content
    } 
    else 
    {
        echo json_encode(["error" => "Error al eliminar la pregunta"]);
        http_response_code(500); // Internal Server Error
    }
}

//AÑADE
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $cuerpo = file_get_contents("php://input");
    $preguntaData = json_decode($cuerpo);


    if (!$preguntaData || !property_exists($preguntaData, 'enunciado')) 
    {
        echo json_encode(["error" => "Datos de pregunta no válidos"]);
        http_response_code(400); // Bad Request
        exit;
    }

    $pregunta = new Pregunta(
        $preguntaData->enunciado,
        $preguntaData->respuesta1,
        $preguntaData->respuesta2,
        $preguntaData->respuesta3,
        $preguntaData->correcta,
        $preguntaData->url,
        $preguntaData->tipoUrl
    );

    $result = $repoPregunta->insertObjeto($pregunta);

    if ($result) 
    {
        http_response_code(201); 
    } 
    else 
    {
        http_response_code(500); 
    }
}
?>
