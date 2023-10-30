<?php
include 'metodos/metodoPintaMenu.php';
crearMenu(); 
echo '<li><a href="/plantilla/plantillaPregunta.html">Iniciar Sesión</a></li>';
echo '<li><a href="/plantilla/examen.html">Iniciar Sesión</a></li>';
include 'db/db.php';
$con = db::obtenerConexion();
session_start();

