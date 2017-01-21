<?php
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$actividad = $_POST['actividad'];
?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-pencil info" aria-hidden="true"></span>
            Modificación de datos del profesor seleccionado:
        </div>
        <div class="panel-body">
            <form action="pagina.php" method="post">
                <input type="hidden" name="ejercicio" value="02">
                DNI: <input type="text" name="dni" value="<?= $dni ?>" readonly="readonly"><br>
                Nombre: <input type="text" name="nombre" value="<?= $nombre ?>" required="required"><br>
                Dirección: <input type="text" name="direccion" value="<?= $direccion ?>" size="60"><br>
                Teléfono: <input type="text" name="telefono" value="<?= $telefono ?>" required="required"><br>
                Actividad: <input type="text" name="actividad" value="<?= $actividad ?>" required="required"><br>
                </div>
                <div class="panel-footer">
                    <input type="submit" class="btn btn-success" name="accion" value="Modificar">
                    <a class="btn btn-danger" href="pagina.php?ejercicio=02" role="button">Cancelar</a>
                </div> 
            </form>
        </div>
    </div>