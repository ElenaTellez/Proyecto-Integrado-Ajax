<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}

?>

<h3 align="center">Listado Alumnos
    <select id="idtipo">
        <option value="">------</option>
        <?php
        $consulta2 = $conexion->query("SELECT dni, nombre 
			FROM alumno ORDER BY nombre");
        while ($fila2 = $consulta2->fetchObject()){
            ?>
       <option value="<?=$fila2->dni?>"
<?php if (!empty($_POST["id"]) && $_POST["id"]==$fila2->dni) echo ' selected="selected" '?>
><?=$fila2->dni?></option>
<?php } ?>
        </select>    
	<!--<span id="carga"><img src="img/ajax-loader.gif" id="cargando" /></span> -->
<input id="filtrar" type="button" value="Filtrar por DNI" />
</h3>

<h3 align="center">Búsqueda por Colegio <input type="text" id="buscausuario" value=""></h3>
