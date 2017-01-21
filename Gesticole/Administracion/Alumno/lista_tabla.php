<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}
$consulta = $conexion->query("SELECT a.dni, a.nombre, a.colegio, a.edad, a.curso, b.nomActiv as actividad FROM alumno a, actividad b WHERE a.idActividad = b.idActividad");

//Ordena por click en los th
//Si llega el parametro ordenapor se ordena por ese campo

if (empty($_POST["ordenapor"])) {
    $consulta = $conexion->query("SELECT a.dni, a.nombre, a.colegio, a.edad, a.curso, b.nomActiv as actividad FROM alumno a, actividad b WHERE a.idActividad = b.idActividad ORDER BY nombre");
} else {
    sleep(1); //simula retraso de 1 seg en servidor
    $ordena = "actividad";
    $consulta = $conexion->query("SELECT a.dni, a.nombre, a.colegio, a.edad, a.curso, b.nomActiv as actividad FROM alumno a, actividad b WHERE a.idActividad = b.idActividad ORDER BY $ordena");
    }


//---------------------------------------------------------------------------

//Consulta en función de nombre de colegio
if (!empty($_GET["busquedausuario"])) {
    $consulta = $conexion->query("
SELECT *
FROM alumno
WHERE colegio LIKE '%" . $_GET["busquedausuario"] . "%' ");
}

//Filtra por input
if (!empty($_POST["id"])) {
    sleep(1); //simula retraso de 1 seg en servidor
    $consulta = $conexion->query("SELECT a.dni, a.nombre, a.colegio, a.edad, a.curso, b.nomActiv as actividad FROM alumno a, actividad b WHERE a.idActividad = b.idActividad and a.dni='" . $_POST["id"] . "'");
}



//---------------------------------------------------------------------------

if ($consulta->rowCount() > 0) {
    ?>

                        
                <table id="tabladatos" class="table table-responsive">
                    <tr>
                        <th name="dni">DNI</th>
                        <th name="nombre">Nombre</th>
                        <th name="colegio">Colegio</th>
                        <th name="edad">Edad</th>
                        <th name="curso">Curso</th>
                        <th class="ordena" name="actividad">Actividad</th>
                        <th> <a href="#" id ="nuevo">AGREGAR NUEVO</a></th>
                        <th></th>
                    </tr>

                    <?php
                    while ($unAlumno = $consulta->fetchObject()) {
                        ?>
                        <tr id="dni_<?= $unAlumno->dni ?>" data-id="<?= $unAlumno->dni ?>">
                            <td class="dni"><?= $unAlumno->dni?></td>
                            <td class="nombre"><?= $unAlumno->nombre?></td>
                            <td class="colegio"><?= $unAlumno->colegio?></td>
                            <td class="edad"><?= $unAlumno->edad?></td>
                            <td class="curso"><?= $unAlumno->curso?></td>
                            <td class="actividad"><?= $unAlumno->actividad?></td>
                            <td>            
                                <a class="borrar btn btn-danger glyphicon glyphicon-trash"> Eliminar</a>
                                     
                            </td>
                            <td>
                                     
                                <a class=" modificar btn btn-danger glyphicon glyphicon-pencil">Modificar</a>
                               
                            </td>            
                        </tr>
                
                        <?php
                    }
                    ?>
                </table>
Número de Alumnos: <?= $consulta->rowCount() ?>
<?php }
//while 
?>