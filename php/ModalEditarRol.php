<!--ventana para Update--->
<div class="modal fade" id="editChildresn<?php echo $dataRol['codigo_rol']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #e01947 !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Actualizar Información
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="POST" action="recib_UpdateRol.php">
        <input type="hidden" name="codigo" value="<?php echo $dataRol['codigo_rol']; ?>">

        <div class="modal-body" id="cont_modal">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Codigo Rol:</label>
            <input type="text" name="codigo" class="form-control" value="<?php echo $dataRol['codigo_rol']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nombre Rol:</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $dataRol['nombre_rol']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Estado:</label>
            <input type="text" name="estado" class="form-control" value="<?php echo $dataRol['estado']; ?>" required="true"> 
           
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Guardar Cambios</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->