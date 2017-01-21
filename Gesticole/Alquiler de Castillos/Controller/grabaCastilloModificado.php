 <?php
  require_once '../Model/Castillo.php';
  
  $castilloAux = new Castillo($_POST['idNuevo'],$_POST['tituloNuevo'], $_POST['descripcionNueva'], "");
  $castilloAux-> update($idNuevo, $tituloNuevo, $descripcionNueva, $imagenNueva);
  header("Location: indexController.php");