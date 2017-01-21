<?php


try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}

$listadoActividades = "SELECT  nomActiv, idActividad FROM actividad";
?>


<form id="formulario" method="POST">
  Dni:<input id="dniModificar" ><br>
  Nombre:<input   id="nombreModificar"  ><br>
  Colegio:<input   id="colegioModificar"><br>
  Edad:<input  id="edadModificar"><br>
  Curso:<input   id="cursoModificar"><br>
  Actividad: <select id="actividadModificar">  
         <option value="1">------</option>
        <?php       
        $consulta2 = $conexion->query("SELECT nomActiv, idActividad FROM actividad ORDER BY idActividad");
        while ($fila2 = $consulta2->fetchObject()){
        ?>
       <option value="<?=$fila2->idActividad?>" name="actividad"><?=$fila2->nomActiv?></option>
<?php } ?>
           </select> 
</form>
 
