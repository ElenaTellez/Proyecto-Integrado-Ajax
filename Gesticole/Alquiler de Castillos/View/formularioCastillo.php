 
     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
         <div id="personal" class="jumbotron">
            
            <h4><span class="glyphicon glyphicon-pencil info" aria-hidden="true"></span>
            Añadir un nuevo elemento al listado de castillos:</h4>
            <form action="../Controller/grabaCastillo.php"  enctype="multipart/form-data" method="POST">
                <h3>Título</h3>
                <input type="text" size="10" name="titulo" required="">
                <h3>Imagen</h3>
                <input type="file" id="imagen" name="imagen" width="20" height="20">
                <br><h3>Descripción</h3>
                <textarea name="descripcion" cols="30" rows="6" required="">
                </textarea><hr>
                </td>    
                <input type="submit" value="Aceptar">
                <a href="../index.php">           
                <img id="cancelarnuevo" src="img/borrar.png" width="20" height="20" alt="Cancelar">
                </a>
            </form>
     </div>
  </div>
