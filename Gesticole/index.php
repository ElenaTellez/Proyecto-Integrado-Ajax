 <?php
 
        if (!isset($_SESSION['logueado'])) {
            $_SESSION['logueado'] = false;
        }
        session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gesticole</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
    </head>
    <body>
        
       
        <div id="encabezado" class="flex-container-inline">
            <div id="header">
                <div id="contenedor">
               
                <div id="titulo"><br><br><h1>GESTICOLE</h1></div>
                </div>
            </div>

            <div id="login">
                <form action="index.php" method="post">
                    <div> <span id="uno"></span>&nbsp;&nbsp;Login</div>
                    <table>    
                        <tr>   
                            <td id="libre"> <input type="hidden" name="ejercicio" value="index">
                                <label for="usuario">Usuario</label> </td>   
                            <td id="libre"><input type="text" name="usuario" required="required" autofocus></td>
                        </tr>
                        <tr>
                            <td id="libre"><label for="clave">Contraseña</label></td>                   
                            <td id="libre"><input type="password" name="contrasena" required="required"></td>
                        </tr> 
                        <tr>
                            <td id="libre"><a href="02_alta_usuario.php" class="boton">Nuevo Registro</a></td>                   
                            <td id="libre"> <input type="submit" value="Iniciar sesión"><span id="dos"></span></td>
                        </tr> 
                    </table>
                </form>-
            </div>
        </div>
        
           
   
            <div id="menu" class="flex-container">
                <ul>
                    <li><a href="#">Actividades deportivas</a></li>
                    <li><a href="#">Refuerzo educativo</a></li>
                    <li><a href="#">Viaje fin de curso</a></li>					
                    <li><a href="#">Novedad: Alquiler de castillos hinchables</a></li>
                    <li><a href="#">Campamento de Verano</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
        
              
        <div id="contenido" class="flex-container">
            
            
        <div id="izquierda"><img src="img/logo.jpg" alt=""/></div>
        <br><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do   eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad   minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip   ex ea commodo consequat. Duis aute irure dolor in reprehenderit in   voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur   sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt   mollit anim id est laborum.
</p>  <br><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do   eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad   minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip   ex ea commodo consequat. Duis aute irure dolor in reprehenderit in   voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur   sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt   mollit anim id est laborum.
</p>  <br><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do   eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad   minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip   ex ea commodo consequat. Duis aute irure dolor in reprehenderit in   voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur   sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt   mollit anim id est laborum.
</p>  
            
         <div id="galeria">
                <div id="portaFoto">
                    <div class="foto1"></div>
                    <div class="foto2"></div>
                    <div class="foto3"></div>
                    <div class="foto1"></div>
                    <div class="foto2"></div>
                    <div class="foto3"></div>
                    <div class="foto1"></div>
                    <div class="foto2"></div>
                    <div class="foto3"></div>
                    <div class="foto1"></div>
                    <div class="foto2"></div>
                    <div class="foto3"></div>
            </div>


</div>
        
          </div>
         

        <?php
        
        
        // Comprueba nombre de usuario y contraseña. Ademas se controla los accesos a
        // información o datos de administrador de la página
        
        if (isset($_POST['usuario'])) {
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die("Error: " . $e->getMessage());
            }
            $contrasena = $_POST['contrasena'];
            $consultaClave = "SELECT usuario, tipo FROM acceso WHERE clave =\"$contrasena\"";
            echo $consultaClave;
            $consulta = $conexion->query($consultaClave);
            $visita = $consulta->fetchObject();
            
            if (($_POST['usuario'] == $visita->usuario) && ($visita->tipo == 'administra')){
                $_SESSION['logueado'] = true;
                 include '../Administracion/02.php';
            } else {
                echo '<script type="text/javascript">alert("Contraseña o usuario incorrecto");</script>';
            }
        }
        ?>


    </body>
</html>

