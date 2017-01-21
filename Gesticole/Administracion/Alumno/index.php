<?php
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
} catch (PDOException $e) {
    echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
    die("Error: " . $e->getMessage());
}
$consulta = $conexion->query("SELECT dni, nombre, colegio, edad, curso, actividad FROM alumno");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PERFIL USUARIO DE ADMINISTRACION GESTICOLE</title>

        <link href="../../css/estilos_admin.css" rel="stylesheet">
        <link href="../../css/bootstrap.min.css" rel="stylesheet">        
        <link rel="stylesheet" type="text/css" href="ui-lightness/jquery-ui-1.10.3.custom.css"/>


        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.js"></script> 
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script type="text/javascript">

            $(document).ready(function () {
                var idtipo;
                var id;
                var ordenapor;

                //VENTANA DIALOGO DE BORRAR
                $("#dialogoborrar").dialog({
                    autoOpen: false,
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Borrar": function () {
                            $.get("eliminar.php", {dni: id}, function () {
                                $("#dni_" + id).fadeOut(1000);
                            });
                            //get			
                            //cierra ventana dialogo				
                            $(this).dialog("close");
                        },
                        "Cancelar": function () {
                            $(this).dialog("close");
                        }
                    }//buttons
                });
                //---------------------------------------------
                //BORRAR
                $(document).on("click", ".borrar", function () {
                    id = $(this).parents("tr").data("id");
                    $("#dialogoborrar").dialog("open");
                });

                //---- NUEVO --------------
                //Boton de añadir nuevo crea nueva fila al final de la tabla Con dos nuevos botones (guardarnuevo y cancelarnuevo)

                $(document).on("click", "#nuevo", function () {
                    $.post("formulario_alumno_nuevo.php", function (data) {
                        //Añade a la tabla de datos una nueva fila
                        $("#tabladatos").append(data);
                        //Ocultamos boton de nuevo inmueble para evitar añadir mas de uno a la vez
                        $("#nuevo").hide();
                    })//get	
                });

                //Boton de cancelar nuevo
                $(document).on("click", "#cancelarnuevo", function () {
                    //Elimina la nueva fila creada
                    $("#filanueva").remove();
                    //vuelve a mostrar el botón de nuevo (+)
                    $("#nuevo").show();

                });

                //Boton de guardar nuevo
                $(document).on("click", "#guardarnuevo", function () {
                    $.post("insertar_nuevo.php", {
                        "dniNuevo": $("#dniNuevo").val(),
                        "nombreNuevo": $("#nombreNuevo").val(),
                        "colegioNuevo": $("#colegioNuevo").val(),
                        "edadNueva": $("#edadNueva").val(),
                        "cursoNuevo": $("#cursoNuevo").val(),
                        "actividadNueva": $("#actividadNueva").val(),
                    }, function (data) {
                        //Pinta de nuevo la tabla
                        $("#contenedor").html(data);
                        //Vuelve a mostrar el boton de nuevo
                        $("#nuevo").show();
                    })//post	
                });
//---------------------------------------------------
                //MODIFICAR
                $("#dialogomodificar").dialog({
                    autoOpen: false,
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Guardar": function () {
                            $.post("modificado.php", {
                                dniModificar: $("#dniModificar").val(),
                                nombreModificar: $("#nombreModificar").val(),
                                colegioModificar: $("#colegioModificar").val(),
                                edadModificar: $("#edadModificar").val(),
                                cursoModificar: $("#cursoModificar").val(),
                                actividadModificar: $("#actividadModificar").val()
                            }, function (data, status) {
                                $("#contenedor").html(data);
                            })//get			

                            $(this).dialog("close");
                        },
                        "Cancelar": function () {
                            $(this).dialog("close");
                        }
                    }//buttons
                });
                //Boton Modificar	
                $(document).on("click", ".modificar", function () {
                    //Obtenemos el id de la fila
                    id = $(this).parents("tr").data("id");
                    //Para que ponga cada campo con su valor

                    $("#dniModificar").val($(this).parent().siblings("td.dni").html());
                    $("#nombreModificar").val($(this).parent().siblings("td.nombre").html());
                    $("#colegioModificar").val($(this).parent().siblings("td.colegio").html());
                    $("#edadModificar").val($(this).parent().siblings("td.edad").html());
                    $("#cursoModificar").val($(this).parent().siblings("td.curso").html());
                    $("#actividadModificar").val($(this).parent().siblings("td.actividad").html());
                    //Muestro el dialogo
                    $("#dialogomodificar").dialog("open");
                });
                //Ordenar pulsando th
                //-------------------------------------------------------

                $(document).on("click", ".ordena", function () {

                    //obtener el ordenapor
                    ordenadelth = $(this).attr("name");
                    $.ajax({
                        url: "lista_tabla.php",
                        data: {ordenapor: ordenadelth},
                        type: "post",
                        beforeSend: cargar,
                        success: rellenar,
                        complete: final,
                        cache: false
                    });
                });
                //Se ejecuta en el tiempo de espera del servidor
                function cargar() {
                    //Muestra el gráfico de cargar
                    var cargando = '<span><img src="images/loader.gif" id="cargando" /></span>';
                    $("#contenedor").html(cargando);
                }

                function rellenar(data) {
                    $("#contenedor").html(data);
                }

                //Una vez cargado vuelve a ocultar el gif animado			
                function final() {
                    $("#cargando").hide();
                }
                //----------------------------------------------------
                //AUTOCOMPLETADO
                $(document).on("keypress keyup", "#buscausuario", function () {
                    var valor = $("#buscausuario").val();
                    $.get("lista_tabla.php",
                            {
                                busquedausuario: valor
                            },
                            function (data) {
                                //vuelve a pintar el listado
                                $("#contenedor").html(data);
                            }); //get

                });
                //----------------------------------------------------
                // FILTRAR				
                $(document).on("click", "#filtrar", function () {
                    ////Cargo en la vble global el tipo seleccionado			
                    idtipo = $("#idtipo").val();
                    //Llamo Ajax con la función ajax
                    $.ajax({
                        url: "lista_tabla.php",
                        data: {id: idtipo},
                        type: "post",
                        beforeSend: cargar,
                        success: filtratabla,
                        complete: fin,
                        cache: false
                    }); //ajax														

                });
                //Se ejecuta en el tiempo de espera del servidor
                function cargar() {
                    //Muestra el gráfico de cargar
                    var cargando = '<span><img src="images/loader.gif" id="cargando" /></span>';
                    $("#contenedor").html(cargando);
                }

                //Cargar en el contenedor el resultado de la tabla con filtro				
                function filtratabla(data) {
                    $("#contenedor").html(data);
                }

                //Una vez cargado vuelve a ocultar el gif animado			
                function fin() {
                    $("#cargando").hide();
                }

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
                    $("#edad").datepicker({
                        changeYear: true,
                        changeMonth: true,
                        yearRange: "2000:2017"
                    });
                });


            });//ready

        </script>        
    </head>
    <body>
        <div class="container-fluid">                
            <div class="container">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <div id="personal" class="jumbotron">
                        <h2 class="text-center">Alumnos</h2>
                    </div>
                    <div id="personal" class="jumbotron">
                        <div class="row placeholders">
                            <div class="col-xs-6 col-sm-3 placeholder">
                                <a  href="../../Alquiler de Castillos/index.php">
                                    <img src="data:image/gif;base64,/9j/4AAQSkZJRgABAgAAZABkAAD/7AARRHVja3kAAQAEAAAANAAA/+4ADkFkb2JlAGTAAAAAAf/b
                                         AIQACAUFBQYFCAYGCAsHBgcLDQoICAoNDwwMDQwMDxEMDQwMDQwRDhESExIRDhcXGRkXFyEgICAh
                                         JSUlJSUlJSUlJQEICQkPDg8dExMdIBoVGiAlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUlJSUl
                                         JSUlJSUlJSUlJSUlJSUlJSUl/8AAEQgAmQCdAwERAAIRAQMRAf/EAJMAAQACAgMBAAAAAAAAAAAA
                                         AAAHCAEGAgMEBQEBAAAAAAAAAAAAAAAAAAAAABAAAQMDAgMCBgoLDAoDAAAAAQIDBAARBRIGITEH
                                         EwhBUSIyFNRhcZNUtBWVFzcYkaGxQiMzc4QlZXXwgcFSYnKyJJTENRaCQ4PD0zREhdU2JkYnEQEA
                                         AAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCf6BQKBQKBQY0i97cbWvQZoFqDWN6uZGMiCrGw
                                         vTFLnRUvJCw0G2+0up2552ISLezQbBCI9HSBw03BHi40HfQKBQKBQKBQYtQY0DXr8NrUHKgUCgUC
                                         gUCgUHVKlRocdyTJcSywykrccWoJSlKRdSiVWAAFBW/qb12GbzDbG35S4eKxzqVsvpSpLkh1o3S8
                                         vyeDYPmI8PNXGyUhKvSvqRD3dEDS1oYzMdsKlxgeDiBYekMDwoJUL/xSePMEhv4N6DNAoFAoFAoF
                                         AoFAoFAoFAoFB1SpLEWO7IkOJZYYQpx11ZCUIQkFSlqUogAACgq31u6tTtyyBhcU44zt1s3W5xSq
                                         YtJ4KXfyg0nmlBP8pQvpCQioIUUFdvJSQCfZNyPuUHtw+cy2GyMXJYySuJNgr7SM8g8UKPMWNwUq
                                         5KSQQRwIIoLadJerWK37iiheiHuGGkKnwQeBHBPpMbUSVNKJ4gklB8k38lSg3wH7tBmgUCgUCgUC
                                         gUCgUCgUCgUESd4zdmPw+OxGLycGRkcdlHH3X2I8wwtRi9loQ8Qy92iNT+rTw8pINBDLm7OlsqyX
                                         9ryQE8QVZJY4nmBoYJoO0bq6VBBbG2nQ2eJSMguxPtei2oPE/ufpYXVW2hJcHABYzDiAQB4E+i8K
                                         Dvxe/NiYfIMZPD7Ym4/JRFdpHkt5pZUlXKxBiWUlQJSpJ4KSSDQXAANuHA3F6DlQKBQKBQKBQKDi
                                         4422hS3FBCEAqUpRsAkcSSfAKDpZyEB9wNsSGnVkFQShaVHSLAmwPIFQoOD+XxkdxTT8lppxFipK
                                         lgEXGoX48OFByeyUBhAW8+hpBNgpZ0pJtewJoOUafDl6vRnkPaOCtBvY8+NqDvoIA73H/wBXH7Q/
                                         ulBX+glLZPSDAZrbcTNZbLKiKyD6GWI7a2QoJKghTi+0ufOvZNvBfjQaVvfa6dr7hkYhMlM1DGkt
                                         yEWs4haQ4hdhe10qF+J48Lmg+Hb7FBf0UGaDwpzmLU6GRIbDhX2ekrQDrvp0W1c78LUHokToUbT6
                                         S+2xruU9otKL6bXtqI5XFBgz4YZEgOoVHOr8MlQKBouFeUOHAig8WI3XtnNurZw2TiZNxoBTqYj7
                                         b5Qk8isNqVa9B9SgUCg17qOf/wA/3IL2/RE+39mcoKndM+oDuw8+7mWYSJ7jsVyKGlrLYTrW2vXq
                                         SF8uz5WoOree/pO5d1TtwCIiGch2JVHKi4EllhEe4V5HndnflwoPt716z5Dd+0WcFOx7MaUy+h4y
                                         YylJbKUJcQEhpZWRdLnHyj9u1BJ3dW1jbGQJvZU8hJPLSGUHh/pUE3UEAd7jntf/ALj/AHSgr/Y0
                                         FnOmyZKel22U+jtuBMtPlKWAbiW4NfmK83lwNBEHXperqhlAQErS3EC0jiAfRmlWBIHgNBojaFLc
                                         ShPnLISPbJoL9oUFpCgLA+Og5UFNN1ZFW3+sORyyAJHxfnnpYZ1FOoMTC6GlKAVYeRbw0Hp6qdWZ
                                         HUP4t7fHoxwxhkadDpd1+kdlzulvzexoPdhOtJxvTVeyF44OIVGmRBLDh1Wml1Zc0lP3hdta/Gg+
                                         t3VC2OoGQvftDiXQnxW9IjXv9qgs9QKBQeHPYxvKYafjXEa258V6MtOot6kutqbKStKVqT53MA28
                                         VBUjI5Lp7i5z+MyOypTU+A4qPJQc0rg62opWPJiqT5w8BtQcI+6OmSFjTs+UgK8lROZWU2PA3Hol
                                         BymRunclwOMYXIREhNuzZyjZSTcnVd6C8q/g5/vUFg+huBh43agkxILuOjTV9oy3IeL7q0aUoDyl
                                         dkykdoUlQ0ptYgjgaCQ6CAO9xz2v/wBx/ulBASeHP91vEaD7eP33vXGwWcfAy0uLCjm7MdtwpQk6
                                         i5wA/lG9B8vKZXI5ac5kMlIXLmv6e1fdOpatCQhOo+wlIFB1Q/8Am2fyiP6QoL7s/ikfzR9yg534
                                         X8FBVzqmjZu3N85ONndqPzJc592e3Mbyy2m325Tq3EuJb9E8iyrpIubKB4kcSGsNbg6YuLDaNmyy
                                         pZsP005/BEoPo9t0zsU/5Vf53P6VcJFh4+wFBJ/QfDYCRmJubw2FXiGG2VRXHlzFyC4tS23uzbQW
                                         kBISEgqOrwiwPgCaqBQYBB5eCgwoX8F6Cs/W7eUvDdSMjDaxmHlpS3GV2svGRZDyiphs/hHXUFSr
                                         chx4CwoNJPUvIjicJt/hz/Q0L/hUHe31Wm6AhzDYa55qRjYqbeylPZ/w0FxIbLLERpllCW2m0JSh
                                         CQEpSAOASkcAB4qDtoIA72qmx/ltKgS4RNKDfgADH1XoIBSTf2fBQTV016cbGl7Hx+czkGRk5uYn
                                         oZASialphgSFRlJQqJoCyrQSVFR8AtcUEcdS9vY3be+Mnh8YXTAjqbUwJCVIdSh9lt/QoLCVeT2m
                                         m5HEcaDW0KKVBSeCkm4Psigv6kWTYeDhQYUL0EMd5TPu4JnAusQsfMXIVLSr0+ExM0hIZI7Lt0r0
                                         ed5VufDxUEMI6n5JBBGE2+FDkoYeIk/ZS2KDu+djI9nb4lwnafxvi2Np5/xdF/t0FjOieWcymwsV
                                         kHWGI7koSdbcVpDLQKZLqLpbbCUpvooN+oFBhIIFjQZoKk94k26sZP8AJRPZ/wCnboJG2L0y2aja
                                         O3FZDBKykvOtGRMmKA1FDkV55DTSu3SWtIKQkpAva/OggfdGMjYTduVxccKcjYyfJjM9sQpakMPL
                                         bT2mkJSVEJF7ACgvOgWQB4hb7FBmgr73uPxu2P5s/wC7GoICoLNdMGsv81O2Esy47UdM1DgDsZbi
                                         gDOcWq7gkt/fE8QkUEQ9eUyB1VzJkLS46REKnG0FtCv6owLpQpThHK3nGg0MUF/xQKCB+9qn+obe
                                         VbgHZQB9tLV/uCg+D0f2rg5mwp+byOPOTkIfMZpKwlbaEp0qVZBWjUpXa8fEB7dw1vrttjD7c3Sx
                                         HxEX0GLNjiUY9k2QorW0QgpKjpPZ6rX8PitQTv3e2kjpLhXPvlel8famP0EgOr0IUrxDhQef09Wn
                                         zBqtzvwv7VB66BQVJ7xP0r5P8lE+Dt0ExbXyUP8AyxsxJ3PGjliFHDkcqhXZPxetCfxg1p0E6T4a
                                         CufUFbbm/NxONOB9teUmqQ6kpIWlUhZCwUeSbjjwoLv3A4E8aAFpKtN+PO1BB3eg25n82vAKw+Pk
                                         5L0QTA+mKy4+pHadho1BpKrX0mgg2fsfdeOiok5HGyYLbhAR6Sy4zcniE3cSlN7cbXoO+HsrqBJj
                                         NyIWKyL8VwfgnWWnFNqHLyVIuDyoPn5Pbu44EsRsnAlR5jgBDTzaw6R5o8kjV4LCg+jD6d77VJQF
                                         7eyaEJIUsrhSEiySL826C7Lah2KVqNhpBJPLlQZDjZIAUCTyAIoIL72v+F7e/Lyv6DVB83o5KYb6
                                         WTml5VrHrVNdIZdVHFxpZ8sh+3A2tzoNc7xU9l/dkFmPNayTXxe0pT7amlgKD8gdndnybgfdoJr7
                                         vn0Q4P8APPhsig3yQ2XG9I53vQeb0JzRfhrvy8FqD20CgqR3ivpYyfH/AFUT4O3QRyVDwezQCQT7
                                         FBY3qf1s6cbi2Ll8Njpzr02U0gR0qjuoStaHULtqUgBPm3ubUETdHdz4LbO+o2YzbhagMsSErUlC
                                         3CVLbKUJ0oueJNv3XoNq689R9obuxuLZ29LdkOxnnlPoWy41ZCkoCblYTe5Twtf2bUGubTnYKRs5
                                         /EZHLMYuSZjEltUhLywpDTclopT6OhwpUO0TztwoPl9QsjjpOQxrOMmJnsY/HsR1SGgtDZeSpa16
                                         EuJQrhqAuUi9qDaImQ2pPa2/NkZ6JjnMfHYbkxHmpK3UqbkuOr4stLbV5KwU+UPEbUGl57Melbql
                                         yo7xMJ+UtbfGyezcUVcRcjkqgsRunrt08nbUyuNhzi5NlQn4zAKFISpbrZaSdRAt51+IFBCXR3dU
                                         TBdQYOVzEktwWQ+XFEFZ1OMraSEJSCeJXawoNz7xnUDaG6oWIj4Gb6c7DcfW9Zt1oIDgQE37ZCL+
                                         aeVBDCXlhrsrnRq1FPjPDn9ig4Eigt93fPohwX558NkUEgUCgAg8uNBgqA50FSO8Ub9WMnbjZqJf
                                         +zt0EcmgxY0CxoMigGgxQKBQKBQKAKBQZCSeA50Fvu779EOC/PPhsigkCgeGg4oCgLKt+9QFJJI8
                                         VrEUFZOue9dwYjqZkYcQwywhuMUdvjoElwamEKI7aRHccI1E81cPBwoNFPU3dfjx3yRi/VKB85u7
                                         P1b8kYv1SgfObuz9W/JGL9UoHzm7s/VvyRi/VKB85u7P1b8kYv1SgyOpe7TxHxbb9kYv1SgfOXu3
                                         9XfJGL9v3pQY+czdv6t+SMX6pQD1M3YOfxd8j4v1Sg6k9QtxJd7ZLWKS7cntBhcUFXPM39EvxoDv
                                         ULcTytTzWKcUBYFeFxSjbxcYlBlnqJuRm/Yt4trVbVow2KTe3K9olB2fObuz9W/JGL9UoMjqbuqx
                                         BOOFyL/ojGfb/qvgoLP9D8jJyXS/DzZIaD73pWoMMtRm/JlvIGlmOhttPBP3qR4+dBu9Bjjq9i1B
                                         mgUFR+8X9LGT/JRPg7dBHBoFAoFAoJe7u3TPE7pnzM5nGRKx+JcaRHiL/FPSFXX+G4+UhsJT5BGl
                                         WrjwBBCetzx2cbjcRFx6EwoqMrjmkMMJDTYbMhP4NKG7AJ9jlQdW/OmO196Y91rIRW2siU/gMo22
                                         BJaWkEIOtOlTiBq4oUbH2wCAptlsdKxeTlYyWkIlwHnY0hIIUA4ytTawCOflJoPLQKBQKBQW/wC7
                                         59EOC/PPhsigkCgUCgUFR+8X9LGT/JRPg7dBHBoFAoFA8FBZbupf+n5bw2yPAf7BugkHfUqKhrFs
                                         rebQ8jJwZKm1LSFhlqQgOO6Sb6UahqPIUGyMvMvsofYWl1l1KVtuIIUhSVC6VJUOBBHIigpL1H+k
                                         Hcv7Xn/CXKDXqBQKBQKC3/d8+iHBfnnw2RQSBQKADQYKgDb9+gqR3i/pXyf5KL8HboI4NAoFAoFB
                                         Zbuo/wDqGW/aH+5boN939jca+3jn34rDz0ifCguOuNoUtcV+QntYylKSSW1/fI80+EUGzRY8aJGa
                                         ixm0R47CEtsstJCEIQkBKUIQmwSkDgBQUm6jfSDuX9rz/hLlBr9AoFAoMhKjyBPtUFvu779EOC/P
                                         PhsigkCgeGgwkWFrWoMKTeggzqp0E3nvDe0zPY6VjmIchDCW0yHX0u3aZQ2rUltl1I8pJtZXKg1X
                                         6qnUL3/iPdpPqtA+qp1C9/4j3aT6rQPqqdQvf+I92k+q0D6qnUL3/iPdpPqtA+qp1D9/4j3aT6rQ
                                         SP0t2L1E6d4aVjEwcXmDMk+kl5ORejhPkJbCNC4Dl/Mve/hoNjy6OoeUbjtrweOY9ElR5iSnLOnU
                                         Y7gdCP8ADvvrWoPcMp1I4f8Ax7G/LDv/AI6ghfcfdt6h5zcGRzXpWJjfGcp+WWDIkrLfbuKd7PWI
                                         g1adVr2oPn/VU6h+/wDEe7SfVaB9VTqF7/xHu0n1WgfVU6he/wDEe7SfVaB9VTqF7/xHu0n1Wg5I
                                         7q/UEc5+I58fw0k8P7NQTr0t2rkdp7Fx238ktpybCMjtVsKUps9rIdeTpUtLaj5Lg5poNooMW43o
                                         M0CgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCgUCg
                                         UCgUCgUCgUCgUCg//9k=" width="150" height="150" class="img-responsive" alt="">
                                </a><h4>Castillos Hinchables</h4>                            
                            </div>
                            <div class="col-xs-6 col-sm-3 placeholder">
                                <a href="../Profesor/02.php">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz
                                         AAAOxAAADsQBlSsOGwAACx9JREFUeJztnX+wVVUVxz/fA8gLQQV/ghoUKaXWYDr4YyYsJTSc0XLC
                                         iEpFbGy0sUAHJ8doyikLy6RksjQqy5mcckYnCSZ/MPKHmQ35G0QlH+oQZPkLMPDx7uqPc5DHe+9y
                                         z7t3nV/v7s/M/eOet+8667697tprn7322sKPocAUYCroGGASME4wCjQSGOJ4r3agG2yrwRZgI7AO
                                         bA2wCngU2OlxE7X4+SHAdNAFwNlCoxx0CjTAsC3AMrDfAPcB3c3KatYAOoCLQQuExjd780DrGNYJ
                                         tghYCuwY6OebMYCZoBuFjmjis4GMMOxlsPnAHwfyuYEYwGGgpUKfGphqgTwxbDnYHGBzmvZpDeB0
                                         0B1ChzWvWiAvDNsENhtY2ahtmsj8IqE7hfZvXbVAHgiNFMwGNgBP7K1tIwOYL6IloDCFqxwaIvRp
                                         sDeBR+q12lvHzok7v+WpYqA4JHQmWCd1PEG9zp0mouXED3cClce6DDsLeLD3X/ozgLGgx4QOzV6x
                                         QF4kgeHxwKae16O+TfWr0PmDj3gGp6W9r/c2gPPjMSMwGEme4czc89puOkDPhyd8gxvDXgE7CtgO
                                         e3qAuaHzBz9JH1+8+33MUNB6ofcWo1YgTwzbADYR6N41zZteps43akcCrxStR9kRkTX3OY03bDqw
                                         PBkC9CVHvQKVQBdAPAQMBb1WpmSO4AHS0awHgF1JJTZmKDClTJ3fFz0g+EjRWpQBg9fBjvaQJTTK
                                         sClDgakeAjPkANBBRStRBoQ1/5Pvn6lRksAZaEt0TEScvRtoTyZFwLiitQgUxrgoztsPtCOCUVGy
                                         aSPQlmhkRNix084M6ScfINBOBANoc4IBtDnBANqcvLN+zeItzk8CrxLvah0NTBI6ERiWtJtAWAzK
                                         hVwMINnBuhi4G+is02YMMAN0mYhWGvZzsAV56NfOqJUlxUYYthXsW8ASBrZ1+TzQj4BtwH5CR2ai
                                         YOWw1ww7cNc7j77LzACSX/25xO6+GQ4C3SVU9tXKHPE3gEyCQMP+CXYSzXc+wH/Aphm2wkuvQF/c
                                         DcCwt8DOAf7tIK4LbJZhzzrIygXDnjVsVdF6pCUDD2ALgGccBb4J9kWg5igzQ+xrYKcZ9nTRmqTB
                                         1QAMWwf80lNmwmrD7sxAriuG3Qv8BThP6Lii9UmDaxBo1C4EbveS14vjRPRURrIdsHcM+zCwAbRG
                                         6P0Z3KPMQaBtZ4AFigbI04Y9n6H8ljC4GXgO+Ho2nZ8NbgZgcRWKt73k1eHejOU3hWGvgl0HHAq6
                                         pmh9BoLnk0DPwK8O9kQ5C5bYQuAN0G1C+xWtzUBwHAK0qXGblklV+ixPDHsSuBU4XuiigtUZMJ6z
                                         AJfatQ3oyuEeA8HA5gHdoB9TwewqzyBwtJ+suhyQwz1SY9g9xHV3Pit0WtH6NIOnBzjKUVY9XLZF
                                         +WA7wK4ChoMWFa1Ns3gawMfJfHlZ07KVnx6DxcB6YL7Q+4rWp1m8HwRNAx7wkteL0SLazO6kkcIw
                                         bHOySXME6Ln8NteW+kEQgC71lbcHcylB58fYtcBboO+Ve2d1Y7zzAcyonUx8ooUno0EvCI1xljtg
                                         DHsM7ERgsoj+Tq55laX3AAi0hPhACU+xPypD57N72lcD3cQgSKp1/wJxcqc8VwSvEJrjKK9pDLsL
                                         eAiYKfSxovXxIMuUsFvBLqe1hzeXiWgxpahZbNsNOwb4F2it0IQCdCj9EPAuQl8G3Q80U31sJOgW
                                         oZssXmUsHIO1wFbiad+EQpVxJNOs4BjbbvBTsB/SOE1sBDAH9E3gHbAvgG4S+mi2OvbFsIeJEzy2
                                         gCYDs4i92TChffPWJ9GqOlnB/dBt2F/BlgFPExtDNzAGOBo0XTANNMKwRWDfAbaBVudsAN1G7SvA
                                         bb2ujwctEzo2R116UW0DSM2eZeLyNQDDrgert6b/AaGnQM6znLRUKAZokWOB4XnfNElnv24vTV4w
                                         WJ6bQjlQRHS907D1wOvJewH7EHf4/kKHiGgF0JWkg+dYwtauAP7XoM1a0GdyUScHcjAA6zJYlYz9
                                         K4mj6brbxAwTMBY4DjgBdBZwata6GnY3sKxxSx3YuE11yPI5wBZgCdgSWt/pO5b4qNrLhca2rt2e
                                         GLaNeI7/UoOmw5Oq6od765AO/xgAEZn3C/QnIIsNne8B5sW1jT315eqU978mi/9X+pf+21MZl++e
                                         QedfT/aZmwfHCZhRt4O+z5BulXECaNtgMwDvnUE/AfsGkPXU8lWwS4zaKYb9rQU5lv5xtRYLjWjh
                                         XqXELQYwbHWyI7jps+ybRMCsZG1+QjKVu5m971HoENEPDPsDWJqzEs4R0d1GbSFxZZOi2AH8etcb
                                         l77zc/2c0rIyrdEBXA16A/QycCH1h6KFoNeBNMfjjQC9CPqdl6JelCYGAD1c9D+jBweDlgh1gVYD
                                         n+j194lCbwNfTSdO342NitKdnO7y4/VwI0btSuBGh+/kyYdANwjNMOzPYI/Fl/VJYBjYFBoPVx8U
                                         etzgKUpYqEJE13oI8XD/J7X+dTLjjPgo3Hf17QampPuo7vcaIsv68poFdDrJyYIHwE4wanMN2xgn
                                         qqTKWfy80BlZK1c0HkOAGbXhlG/bVn/sS7x9660G7fYDPZvFU8eyUYJUq1zZlq6ZrmuHzgen5wBG
                                         7XBgo4M+aRHZPWzale7dFj8Orxgg5+Pm9RBwKf45AwL9jDbpfPAzgLxPHTlcRLfED2i4yvH+lwid
                                         7CSrEngZQN7bo3YACI0V0Q2gDaBvA62s1R+ULGS1FVX1AHukiguNEVoI6gTdCDSxXq/va5Ale6Sh
                                         0h6gN0IjheYJrQfdSvqaBaeWZfdR3lTVAzSoPK7hQpeIaC3o98DkvTQemRhLWRNkM8XpS0el8AD9
                                         METocyL6B2gZfc9JnghaoTY+PtdpumOFxgApkNAM4oWh54gLOh4idAIVLOzkidd8t6weoA9CR1Oq
                                         WkPFMqiCwMDAGaRBYCAtVfUApdgyPhgIHqDNqagHsGAATlTVA4QhwAkXA1CYBVQWJw+Qe7HEYABO
                                         eA0Bw8i3oEMwACc8F0Dy9AIhBnDC0wDyDASDB3Ciqh4gGIATVfUAYQhwIniANqeqHiAYgBPBA7Q5
                                         VTWAEAM44WgAURgCKojnuYFhCKggEX5FnYIHqB7dEdhWJ2EhBqgctjUy2OIkLXiAimGwJcJvX3+I
                                         AarHxghY5yQsTw/QTT6nlQ921kVga5yEhczgymFrImCVk7SQGFo9VkXAo0lt/5ZQSA2vFEmfPxoR
                                         j6UpTspoRL55gRaGgFZZBuxMNofab0GzWhTYQZwbWCPecdvzFTle2/V+nxb1bXPsdthdTXtochRK
                                         jgc0BYrCsA1gE4mfBAKwE2xRkUoF8sQWkSwB9Kyn3wF6XuiIYpQK5IFhr4AdRRJD9VwN3A52ZTFq
                                         BfLD5tMjgO7nRA2tEDozR40COWHYcrAZPa/1d6TKYaDHhXIu/xrIEsM2gU0GNve83l9CyKb42Har
                                         Qvn3QCqsC2w2vTof6lfIehF4Sehcsj8DMJAtNcPmAvf098e9lUh7AuzNJB4IRlBNakZtHvCLeg0a
                                         1ch7BKxTcDaorevpVQ/rSn75dTsf0v+yTwfdIVS6o9MCfUkCvtnAykZt02YFPwh2fDyNCJSZZKo3
                                         mRSdDwNLC98ENsOonR8/TQqUCcNeNmozk3l+n2i/Hs0Gdx3AxaAFQuOblBFwwLDO5Nn+UprIkWg1
                                         uh8CTAddAJyt/GsFtSVJMse9yZLufbSwt8NzejeU+ETOqcTl1ycB4+IKYhpJm1flboJusK1J2v5G
                                         YF2Sv7mK+OBLl6TY/wMNvVYjAY/5WQAAAABJRU5ErkJggg==" width="150" height="150" class="img-responsive" alt="Link zona profesores">
                                </a><h4> Profesores</h4>
                            </div>
                            <div class="col-xs-6 col-sm-3 placeholder">
                                <a href="../02.php">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz
                                         AAAOxAAADsQBlSsOGwAAB99JREFUeJztnV2sHVUZhp93OG2PQJVowbQCaptaTfFg9MKEP6MGYzVq
                                         IhCDkQuDJsbE2MbECxMTJZiIXACp0eBfjAlWYgUTDQgWUgXxpgkIQWxto6a0RIiiocVibZcX+xzP
                                         7HH2PrNmr5k1M+t7kn2x2z2zvjXvc+Z/1oBhGIaRKGqhjTXAWuDMmu2dAI4Dx0IWZYwILcBW4F2g
                                         twNvFGwBnR1m1u6Yg78AT4DbBzwIPAa4MPM36rIVdBPosMhcmx/QYdAtoxqMtrkcdJ/ITrcdfMnn
                                         NGgPcEXshdI36mwCNoF2Cm0r+0+HewF4CHgc3AHgaeAFRtvxOqvrsxjtQ2wAvQFYAK4QesWE9n8O
                                         bjtwqEZbxhQEfF7oxZJV8d9BtwPvAFa1UMsZwCWgnaDnSuo5DnyyhTqSYR3onpIFfQTYzmgPPxZr
                                         gE+B/lRS3y7g5RFrGwQbQX8cX7g6AfoKcYMvshr4Auh4QYIngfWxi+srF4GeKVmgF8UubAqbQPsK
                                         Ne8Hzo9dWN94HehIYUHeyWinrOusBn27UPtB4DWxC+sL54D+UFiAt9HOmcOQ3JA/TAX9ltGmwpiO
                                         flIIf2fsimbgxkJfvhm7oK7z6cIC2w1ksYuaDX1vvE9cW/jBHP3YtDXOBtA/c+EfYHQSpu/Mgx7N
                                         9esoy4eHc6Afg34NBLpu0Vv0w9xfykngbbErCsgWoX/lJLgZWAXanfu3pCV4s8hOFXb6hsaXc+cy
                                         XgLdX3LyKFUJtGv81C6l59p7zjzo6QpXGZOTYL3ITuYWwA2xC2qQHRUvNSclwefGV42si12QJwvA
                                         BRV/e2Z+R3cFCR4iDQmWT52C7opdjScXg54DHaKyBPpu1XsNUpBg3fjOH9fELsiDi/OXgz0kuLKq
                                         AClIcE2us6eAV8UuqCJj4XtKMJ8/JExcAt2U6+RjsaupyEJZ+H4SaK+PAEOVIAO25L4/EasQDxZA
                                         DwhN3FEV2gjay3QJvPsqdBnoXgYkQQZsXv7q9kerpBorhr/ESAKum/yLen0dnATK3fABfCJ2PVOY
                                         utovWV3fssL8rvLdBAxycyCyYzkBPhK7ngmEDh/gPbMIMBgJNHbDBB+MXU8JTYQPcNmsAgxBgozx
                                         u3zq3Lff5F1Clbf5AA53K7gdFecd5JGyvu8TzHqjx47RtXTmQhRToMnwg9JrCcZXZ3zAY9IdS5uP
                                         xbuGQkrQ1Go/z6UhNgG93xzUFOB/4ec6H0qCNsKHBgTopQQ1BNheDD+gBG2FDw0J0DsJPAWYGH4A
                                         CdoMHxoUoFcSeAhw/UrhzyBB2+FDwwL0RgIPAS4AHfLofFUJFkDPthw+tCBALyTwEADCSxArfGhJ
                                         gM5L4CkAhJMgZvjQogCdlqCGADCS4OAMEsQOH1oWoLMS1BQA6kvgG/6tzfS8fQE6KYHG7wf8kOfk
                                         vhLc05HwAS6PIUDXJMgYDcS4hO8DkofBvdPhKg3IJLRN6Nwqv3W42xYHe2qKaA+DdunaQQYuPwJn
                                         nQdBvSSoQgvhQ+SxgxYl+AWRH77NHBxd/qqqD1cUCSZBS+EDXNhCG1MRunRxTRBNggz4c+77lgm/
                                         q8LMErQYPqBZ+hqM2BJk4H6X+/6WGedXW4J2wwdm72swYkvwvtwe6mmqP2M3Dd+jgyb39ss4R2T/
                                         iXUUMGU5PEwECdYK/Tt3KBjqzuBKEkQIH+Dq2GF3TALdlytgb8AZT5UgUviA7o4ddNck+HiugFPA
                                         poDzLpUgXvicJ/RS7JC7JsFZoOdzjd8eeP5jEkQMH9BXY4fbUQl083LjOgG8NnAD54MOxg2fc6k4
                                         OERXPm1K8GpQ7ikh3d1AG69sYJ4e6PuxA+26BF8ab5gPt9FoS7xb3Xi7SacleBnoQK7RvxF+UxCD
                                         80BHY4fYFwneKnQi1+g+OnDVagbmQb+KHV7fJPhModFf0s9Rts8A3RU7tJ5KoDsKje5podGQzIN+
                                         GjusPkswV/zrAT0KbGyy0UBsAD0cO6QhSLAa9LNCo8/T3YEkAN4P+mvscIYkwSrQ1/X/D4Pey9j4
                                         QtG5kNHI37091OuyBADXUXgjl8hOgn5A3JdIbQZ9K3/kkuKnrgS+o3tsBX1DqPiKVudw+8DdAdwP
                                         POVbiCebgStBHxW6BP9+DBKH+w24bYze1FqJugvuWtDXhEpfxeZwzwCPA/vBHaH+q2PF6N2Ea0Hr
                                         Gd2ytjCpXcNfgroCzIHuFBrSqeLB4CNBnTGC5kC7LPzu4nOPoe8aYCn8q+uVZrSJwz0C7r1MWRP4
                                         CGDh95CVJKgqwBzoR0JXhSvNaItpElQRwMIfAJMkWEkAC39AlEkwTYBVi+Hb3v6AKEowSQALf8Dk
                                         JSgTwMJPgCUJygT4GMh3pJAlXi80pPcNdx6Hewp4subUj4S+iHK9yL4TeJ7GFBzuRnBfrDv9rMPF
                                         Gz3HBEgcEyBxTIDEMQESxwRIHBMgcUyAxDEBEscESBwTIHFMgMQxARLHBEicJl763Ekcpz8L7Kk5
                                         +ZtEtjtkPV0hGQGAw8Dva067JmQhXcI2AYljAiSOCZA4JkDimACJYwIkjgmQOCZA4pgAiWMCJI4J
                                         kDgmQOKYAIljAiSOCZA4JkDimACJYwIkjgmQOCZA4pgAiWMCJI4JkDgmQOKYAIljAiSOCZA4JkDi
                                         mACJE3q08LOBdYHnGYpngRdrTrsa2BCwlpD8Y/FjGIZhGD78FwzPNGqDDF/CAAAAAElFTkSuQmCC" width="150" height="150" class="img-responsive" alt="Link Inicio">
                                </a><h4> Incio</h4>
                            </div>
                            <div class="col-xs-6 col-sm-3 placeholder">
                                <a href="../../index.php">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAA3NCSVQICAjb4U/gAAAACXBIWXMA
                                         ACeIAAAniAHcxMUlAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAArJQTFRF
                                         ////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                         AAAAAAAAmxootAAAAOV0Uk5TAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIjJCUm
                                         JygpKistLi8xMjM1Njc4OTo7PD0/QEFCQ0RFRkdISUpLTE1OUFJTVFZXWFlaW1xdXl9gYWJjZmdo
                                         aWprbG1ub3BxcnN1dnd5ent8fX6AgYKDhIWGiImKi4yNjo+Qk5SVl5iZm5ydnp+hoqOkpaanqqus
                                         ra+wsbKztLW2t7i5uru9vr/AwcLExcbHycrLzM3Oz9HS09XW19jZ2tvc3d7f4OHi4+Tl5ufo6err
                                         7O3u7/Dx8vP09fb3+Pn6+/z9/gtEKjIAAAb2SURBVBgZxcGLY5VlAQbwZzc2QCBg0GCELwEbipIE
                                         RILLuFgqCKllHqBOAmO6uCSEGo285JJIMiKBbIAiFwu5U3JRhJhcg+FgXEJkt+f/iHeHjXN53u+c
                                         nfNt/X5A8rp9b9G6/5ypWDixK/4vpp7nLecmof31Xsswb/dEO8uvYoQzvdG+3meUCrSrnzHGNLSj
                                         O//LGJf7ov0EKUxH+3mTwjK0pYJfv7PlmR64ZT+Ff+GW3Jlb3lkyEH4a9FY9bzraG0061lOo64gm
                                         X63kTXV/MPDLgBV1DNmJJoaSQZNdDKld9jX44c7ldWyRD8tQMrD6s8WN8r5I1VfeqGWYKbAMJQPr
                                         hwxz/bUuSEnRSUYIwDKUDKwgI1R+G8nrsLSBkQKwDCUDK8hI9S9mIkl3f8RoAViGkoEVZLQ9BUhG
                                         2uzrjBGAZSgZWEHGuPZTtF6vjRQCsAwlAytIYV0PtFL+J1QCsAwlAytI5WAeWmXAMUoBWIaSgRWk
                                         dKQ/WmHIaWoBWIaSgRWkdnIwEjasig4BWIaSgRWkw7l7kKCRF+kSgGUoGVhBulwcgYSMvUqnACxD
                                         ycAK0unKWCRgUA3dArAMJQMrSLeaQYir0wF6CMAylAysID0c6IR4VtFLAJahZGAF6WUV4phDT4/A
                                         MpQMrMfoaQ48jamjl4busAwlA6tnI73UjYGHvmfpaT2aGEoGTdbT09m+cMrcQU9bO6GJoWTQpNNW
                                         etqRCZcSeml4NQchhpJBSM7LDfRSAofcGnr49xg0M5QMmo38mB5qekJbRrfG8s5oYSgZtMheUk+3
                                         30G6t55ON55EGEPJIMyEK3SqHwrl73SqeQDhDCWDcMNO02kzhMl0OjEUEQwlgwj99tPpEcTIrqRL
                                         ZV9EMpQMInXdS5dPsxBtLl2qCxDFUDKI0vsYXYoRJf04Hb74FqIZSgbRBn9OhyOIMp4ODZMQw1Ay
                                         iDHqCzo8gEir6bAIsQwlg1jT6bAKEXJvUNubiViGkoHwHrXrPRDuOWrX74JgKBkI+ZeoFSPcIWql
                                         UAwlAyVA7SDCjKa2Lx2KoWQgbaU2CretoPYQJEPJQBpN7U20SKumtAuaoWSgvU+pOg3NhlAbDy2P
                                         Uh60EdSGoNkMStvhUkXhHFw2UJqBZisoPQGXdylUwOX7lFag2WEqVzvBZTGFX8Al6wKVw7gll9JK
                                         OD1EoQhOyynlIuRRShPglLaZMdbD7UFKjyKkjEpVBtz61TDK53lwy6iiUoaQ7VTWwMuPGGUKvKyl
                                         sh0h56nMhad5Nxjm+rPwNJ/KeTRJq6fyHXgbuoctdhbC23gq9WmwulNp7IY4Mp778CpvuvKP4nTE
                                         0ZNSd1iDqRxGAtLv/vFTd6UjAcepDIY1isp78NUHVEbBepjKn+GrtVQehvU0ldfhq+VUnoZVSmUx
                                         fFVGpRTWEipz4Kt5VJbAKqfyE/iqmEo5rDIqC+GrX1Epg/U8lTfgqz9SeR5WCZUK+GoTlRJYM6js
                                         ha8OUpkBayqVM/DVBSpTYU2kUp8BH+VQmgirgFIf+GgApQJYmbVUxsJHE6jUZqLJYSovw0flVA4j
                                         pILKUfjoJJUKhCylNBS+GU5pKUKmU1oA37xAaTpChlDaA98coDQEt5yh0pgPn3yd0hk0W0lpJnxS
                                         Smklmk2jdKwDfJFzitI0NOtPrRi+mEutP1ocpXS+K3zQvYbSUdz2ErUX4YPfUHsJtxVSu9YHKev/
                                         JbVChNlNbRlS9ha13Qg3i1rdMKRoRAO1WQiXW0vts1ykpM9parW5iLCGDtuykIKc3XRYg0j30eX3
                                         SMEqutyHKBvpMgtJW0CXjYh2P13qHkSSJjXS5X7E2EaXiyORlKKrdNmGWOPo9OVTSEKwjk7jIKyj
                                         W1k6WimznG7roZhrdNvQFa3SfQvdrg+ANJ8eDg1EKxQeoYdF0Dp8Qg8XZ2YhQR1KLtHD0Ww4FDXS
                                         y5HJSETa45X0NBFOr9DbjtGIq2gvvZXDLWs34/hrITzd8y7j2JcND6aG8fxz4b1wGP7CAcZzaSA8
                                         TWYCKl8dm4EoWd99/SQTMAVxvMaEVG/5U1nJD8YM6tylYOzjzy5dubWGCfkt4klfzTa0Jh1xddjC
                                         NvNBNhJwx162kY+6IiG9PmWbOJaHBPXZzzZwqB8S1u1D+m5XD7RCTgV9trEzWiVjBX21KgutNfsG
                                         fVNbmobWG36MPjkxCknptpa+qOiOZAUvM2VXi5GCvFVM0ep8pKboY6bgyDikLOvn1UzSxQXZ8EPn
                                         0rNMQtW8LvBLzjMn2EqnijvCT1mPVdQyYXUbpnaA73Jn7mZC9hX3QhsZPPtvNfR0eV1JIdpU+jfn
                                         bTzVSOX0pvkjM9AuOn/jiV/+ZdPOg59V36i9cPzgrs1vL35y+B1Ixv8AJZHmspR2t/sAAAAASUVO
                                         RK5CYII=" width="150" height="150" class="img-responsive" alt="Salir">
                                </a><h4> Salir del Sistema</h4>
                            </div>
                        </div>
                    </div>


                </div>
                <?php include "index_cabecera.php" ?>
                <div id="contenedor">
                    <?php include "lista_tabla.php" ?>
                </div>
                <!-- CAPA DE DIALOGO ELIMINAR INMUEBLE -->
                <div id="dialogoborrar" title="Eliminar Usuario">
                    <p>¿Esta seguro que desea eliminar el usuario?</p>
                </div>
                <!-- CAPA DE DIALOGO MODIFICAR INMUEBLE -->
                <div id="dialogomodificar" title="Modificar Usuario">
                    <?php include "modificar_alumno.php" ?>
                </div>

            </div>
        </div>
        <p>
            Fecha:
            <input type="text" id="edad" />
        </p>


        <?php $conexion->close(); ?>

    </body>
</html>
