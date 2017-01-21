<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}
 ?>
    <td  class="filaNueva">
        Dni: <input type="text" id="dniNuevo"  value="">
    </td>
    <td class="filaNueva">
        Nombre: <input type="text" id="nombreNuevo" value="">
    </td>
    <td class="filaNueva">
        Colegio: <input type="text" id="colegioNuevo" value="">
    </td>
    <td  class="filaNueva">
        Edad: <input type="text" id="edadNueva">  
    </td>
    <td class="filaNueva">
        Curso: <input type="text" id="cursoNuevo" value="">
    </td>
    <td class="filaNueva">
        Actividad:  
        <select id="actividadNueva">
        <?php
        $consulta2 = $conexion->query("SELECT nomActiv, idActividad FROM actividad ORDER BY idActividad");
        while ($fila2 = $consulta2->fetchObject()){
            ?>
       <option value="<?=$fila2->idActividad?>"><?=$fila2->nomActiv?></option>
<?php } ?>
        </select>
    </td>
    <td class="filaNueva">
        <br>
        <img id="guardarnuevo" src="images/floppy.png" width="35" height="35" alt="Guardar">    
    </td>
    <td class="filaNueva">
        <br>
        <img id="cancelarnuevo" src="images/borrar.png" width="35" height="35" alt="Cancelar">
    </td>
 
    <script>
    $(document).ready(function () {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };


    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#edadNueva").datepicker({
            changeYear: true,
            changeMonth: true,
            yearRange: "2000:2017"
        });
    });
     
  
  });
   </script> 