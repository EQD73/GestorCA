v<!--ventana para Update--->
<div class="modal fade" id="editChildresn<?php echo $dataEval['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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


      <form method="POST" action="recib_UpdateEval.php">
        <input type="hidden" name="codigo" value="<?php echo $dataEval['id']; ?>">

        <div class="modal-body" id="cont_modal">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Momento</label>
            <input type="text" name="momento" class="form-control" value="<?php echo $dataEval['momento']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">% actividades:</label>
            <input type="text" name="poract" class="form-control" value="<?php echo $dataEval['por_actividades']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">% act. final:</label>
            <input type="text" name="poractfinal" class="form-control" value="<?php echo $dataEval['por_actfinal']; ?>" required="true"> 
           
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">% corte:</label>
            <input type="text" name="porcorte" class="form-control" value="<?php echo $dataEval['por_corte']; ?>" required="true"> 
           
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