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
    $usuarioApi->fechaIni=$usuario->getFechaIni();
    echo json_encode($usuarioApi);
}

//ACTUALIZA
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $cuerpo = file_get_contents("php://input");
    $id = $_GET["id"];

    $usuarioData = json_decode($cuerpo);    
    $usuario = new Usuario($usuarioData->contrasena, $usuarioData->correo, $usuarioData->rol);
    $usuario->setCorreo($usuarioData->correo);
    $usuario->setContrasena($usuarioData->contrasena);
    $usuario->setRol($usuarioData->rol);
    $result = $repousuario->update($id, $usuario);

    if ($result) {
        echo "Usuario actualizado correctamente";
        http_response_code(200); // OK
    } else {
        echo "Error al actualizar el usuario";
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
            echo "Error: ID de usuario no válido";
            http_response_code(400); // Bad Request
            exit;
        }
    
        // Llamada al método delete en el repousuario
        $result = $repousuario->delete($id);
    
        if ($result) {
            echo "usuario eliminado correctamente";
            http_response_code(204); // No Content
        } else {
            echo "Error al eliminar el usuario";
            http_response_code(500); // Internal Server Error
        }
    }
    
}
//AÑADE
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $cuerpo = file_get_contents("php://input");
    $usuarioData = json_decode($cuerpo);

    if (!$usuarioData || !property_exists($usuarioData, 'fechaIni')) {
        // Manejar el caso en que los datos no son válidos
        echo "Error: Datos de usuario no válidos";
        http_response_code(400); // Bad Request
        exit;
    }

    $usuario = new Usuario($usuarioData->contrasena, $usuarioData->correo, $usuarioData->rol);
    $result = $repousuario->insert($usuario);

    if ($result) {
        echo "usuario agregado correctamente";
        http_response_code(201); // Created
    } else {
        echo "Error al agregar el usuario";
        http_response_code(500); // Internal Server Error
    }
}

 

?>