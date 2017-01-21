<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
} 
     

$modifica = "UPDATE alumno SET dni=\"$_POST[dniModificar]\", nombre=\"$_POST[nombreModificar]\", colegio=\"$_POST[colegioModificar]\", edad=\"$_POST[edadModificar]\", curso=\"$_POST[cursoModificar]\", idActividad=\"$_POST[actividadModificar]\" WHERE dni=\"$_POST[dniModificar]\"";


$conexion->exec($modifica);

include "lista_tabla.php";
?>