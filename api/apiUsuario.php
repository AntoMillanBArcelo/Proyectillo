<?php
include '../cargador/Autocargador.php';
$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'antonio', 'root');
$repousuario = new repoUsuario($con);

//MOSTRAR
if ($_SERVER["REQUEST_METHOD"]=="GET")
{
    $id=$_GET["id"];
    $usuario=$repousuario->getById($id);
    $usuarioApi= new stdClass();
    $usuarioApi->id=$id;
    $usuarioApi->correo=$usuario->getCorreo();
    $usuarioApi->contrasena=$usuario->getContrasena();
    $usuarioApi->rol=$usuario->getRol();
    echo json_encode($usuarioApi);
}

//ACTUALIZA
if ($_SERVER["REQUEST_METHOD"] == "PUT") 
{
    $cuerpo = file_get_contents("php://input");
    $id = $_GET["id"];

    $usuarioData = json_decode($cuerpo);    
    $usuario = new Usuario($usuarioData->contrasena, $usuarioData->correo, $usuarioData->rol);
    $usuario->setCorreo($usuarioData->correo);
    $usuario->setContrasena($usuarioData->contrasena);
    $usuario->setRol($usuarioData->rol);
    $result = $repousuario->update($id, $usuario->getCorreo(), $usuario->getContrasena(), $usuario->getRol());


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
if ($_SERVER["REQUEST_METHOD"]=="DELETE"){
    if ($_SERVER["REQUEST_METHOD"] == "DELETE") 
    {
        $id = $_GET["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            echo "Error: ID de usuario no válido";
            http_response_code(400); 
            exit;
        }
    
        $result = $repousuario->delete($id);
    
        if ($result) 
        {
            http_response_code(204); 
        } 
        else 
        {
            http_response_code(500);
        }
    }
    
}
//AÑADE
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $cuerpo = file_get_contents("php://input");
    $usuarioData = json_decode($cuerpo);

    if (!$usuarioData || !property_exists($usuarioData, 'contrasena') || !property_exists($usuarioData, 'correo') || !property_exists($usuarioData, 'rol')) 
    {
        echo "Error: Datos de usuario no válidos";
        http_response_code(400);
        exit;
    }

    $usuario = new Usuario($usuarioData->correo, $usuarioData->contrasena, $usuarioData->rol);
    $result = $repousuario->insert($usuario->getCorreo(), $usuario->getContrasena(), $usuario->getRol());


    if ($result) 
    {
        echo "Usuario agregado correctamente";
        http_response_code(201); // Created
    } 
    else 
    {
        echo "Error al agregar el usuario";
        http_response_code(500); // Internal Server Error
    }
}

 

?>