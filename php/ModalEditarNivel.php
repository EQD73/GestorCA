<!--ventana para Update--->
<div class="modal fade" id="editChildresn<?php echo $dataNivel['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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


      <form method="POST" action="recib_UpdateNivel.php">
        <input type="hidden" name="codigo" value="<?php echo $dataNivel['id']; ?>">

        <div class="modal-body" id="cont_modal">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Id:</label>
            <input type="text" name="codigo" class="form-control" value="<?php echo $dataNivel['id']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nivel1:</label>
            <input type="text" name="nivel1" class="form-control" value="<?php echo $dataNivel['nivel1']; ?>" required="true">
          </div>    
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nivel2:</label>
            <input type="text" name="nivel2" class="form-control" value="<?php echo $dataNivel['nivel2']; ?>" required="true">
          </div>  
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nivel3:</label>
            <input type="text" name="nivel3" class="form-control" value="<?php echo $dataNivel['nivel3']; ?>" required="true">
          </div>  
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nivel4:</label>
            <input type="text" name="nivel4" class="form-control" value="<?php echo $dataNivel['nivel4']; ?>" required="true">
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