<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}
?>


<script type="text/javascript">

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


    });//ready
</script>        



<tr id="filanueva" align="center">
    <td>
        Dni: <input type="text" id="dniNuevo" value="">
    </td>
    <td>
        Nombre: <input type="text" id="nombreNuevo" value="">
    </td>
    <td>
        Colegio: <input type="text" id="colegioNuevo" value="">
    </td>
    <td>
        Edad: <input type="text" id="edadNueva">  
    </td>
    <td>
        Curso: <input type="text" id="cursoNuevo" value="">
    </td>
    <td>
        Actividad:  
        <select id="actividadNueva">
            <option value="1">Zumba</option>
            <option value="2">Judo</option>
            <option value="3">Baile</option>
            <option value="4">Futbol</option>
            <option value="5">Hockey</option>
        </select>
    </td>
    <td>
        <img id="guardarnuevo" src="img/floppy.png" width="20" height="20" alt="Guardar">    
    </td>
    <td>
        <img id="cancelarnuevo" src="img/borrar.png" width="20" height="20" alt="Cancelar">
    </td>
</tr>