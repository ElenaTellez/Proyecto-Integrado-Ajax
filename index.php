<?php
//si la session esta iniciada la destruye
if(session_start() == true){
  session_destroy();
}
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start();// Inicia la sesión

if(!isset($_SESSION['usuario']) && !isset($_SESSION['logueado'])) {//comprueba que la variable no esta iniciada.
$_SESSION['usuario'] = " ";
$_SESSION['logueado'] = false;
$_SESSION['tipoUsuario'] = " ";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gesticole</title>
         <script src="js/jquery.min.js"></script>
        <script src="js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />        
    </head>
    <body>
        
       
        <div id="encabezado" class="flex-container-inline">
            <div id="header">
                <div id="contenedor">
               
                <div id="titulo"><br><br><h1>GESTICOLE</h1></div>
                </div>
            </div>
            
             <?php
      //comprueba si se establece conexion con mysql
      //incluye la conexion con la base de datos
       try {
                $conexion = new PDO("mysql:host=localhost;dbname=gesticole;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die("Error: " . $e->getMessage());
            }
      //con esto se realiza una consulta
      $usuarioBBDD = $conexion -> query("select usuario, clave, tipo from acceso");
    
      $_SESSION['usuario'] = $_POST['usuario'];
      $contraseñaIntroducida = $_POST['contrasena'];
      
      while (($usuario = $usuarioBBDD->fetchObject())) {
        if($usuario->usuario == $_SESSION['usuario'] && $usuario->clave == $contraseñaIntroducida && $usuario->tipo == "administra"){ 
          $_SESSION['logueado'] = true;
          $_SESSION['tipoUsuario'] = $usuario->tipo;
          header("Refresh: 0; url=Administracion/02.php");//esto redirecciona a otra pagina
        } else if ($usuario->usuario == $_SESSION['usuario'] && $usuario->clave != $contraseñaIntroducida){
          echo '<script>alert("Contraseña Incorrecta");</script>';
        } else if ($usuario->usuario == $_SESSION['usuario'] && $usuario->clave == $contraseñaIntroducida && $usuario->tipo == "profesor"){
          $_SESSION['logueado'] = true;
          $_SESSION['tipoUsuario'] = $usuario->tipo;
          echo '<script>alert("Contraseña correcta");</script>';//esto redirecciona a otra pagina
        } 
      } 
    ?>

            <div id="login">
                <form id="formularioLogin" action="index.php" method="post">
                    <div> <span id="uno"></span>&nbsp;&nbsp;Login</div>
                    <table>    
                        <tr>   
                            <td id="libre"> 
                                <label for="usuarioId">Usuario</label> </td>   
                            <td id="libre">
                                <input type="text" name="usuario" value="<?=$_SESSION['usuario']?>"></td>
                        </tr>
                        <tr>
                            <td id="libre"><label for="contrasena">Contraseña</label></td>                   
                            <td id="libre"><input type="password" name="contrasena"></td>
                        </tr> 
                        <tr>
                            <td id="libre"><a href="02_alta_usuario.php" class="boton">Nuevo Registro</a></td>                   
                            <td id="libre"> <input type="submit" value="Iniciar sesión"><span id="dos"></span></td>
                        </tr> 
                    </table>
                     
                </form>-
            </div>
            <script>
                $(document).ready(function() { 
        $("#formularioLogin").validate({
            onfocusout: true,
            rules: {                
              usuario: "required",
              contrasena: "required"
            },
            messages: {
              usuario: {
                required: "Usuario requerido"
              },
              contrasena: {
                required: "Contraseña requerida"
              }
            }
        });
        });
      </script>
           
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
                
       


    </body>
</html>

