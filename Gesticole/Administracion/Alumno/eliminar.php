<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}
    
    $consulta = $conexion->query("DELETE FROM alumno 
			WHERE dni = '". $_GET["dni"] . "'");
		
    $conexion->exec($consulta);
    
?>
    
    
    