<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}

$insercion = "INSERT INTO alumno (dni, nombre, colegio, edad, curso, idActividad) "
         . "VALUES ('$_POST[dniNuevo]','$_POST[nombreNuevo]','$_POST[colegioNuevo]', '$_POST[edadNueva]', '$_POST[cursoNuevo]','$_POST[actividadNueva]')";
                        
$conexion->exec($insercion);

include "lista_tabla.php";
?>

