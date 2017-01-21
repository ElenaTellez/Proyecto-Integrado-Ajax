<?php
require_once '../Model/Castillo.php';

$castilloAux = new Castillo($_GET['id']);

 
?>
<form id="formulario" method="post">
    Id: <input type="number"   name="idNuevo" value="<?=$castillo->getId()?>"> <br>
    Titulo: <input type="text" size="10" name="tituloNuevo" value="<?= $castillo->getTitulo()?>"> <br>
    Descripción: <input type="text" name="descripcionNueva" value="<?= $castillo->getDescripcion() ?>"> <br>  
    </form>

 
 

Id: <input type="number" value="<?=$castillo->getId()?>"> <br>
 