<?php
include '../cargador/Autocargador.php';
$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'antonio', 'root');
$repoUsuarioExamen = new repoUsuarioExamen($con);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET["userId"];
    $examenesAsociados = $repoUsuarioExamen->getByUserId($userId);
    echo json_encode($examenesAsociados);
}
