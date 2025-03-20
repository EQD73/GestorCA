<!--ventana para Update--->
<div class="modal fade" id="editChildresn<?php echo $dataPeriodo['codigo_periodo']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

      <form method="POST" action="recib_UpdatePeriodo.php">
        <input type="hidden" name="codigo" value="<?php echo $dataPeriodo['codigo_periodo']; ?>">

        <div class="modal-body" id="cont_modal">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Codigo Periodo:</label>
            <input type="text" name="codigo" class="form-control" value="<?php echo $dataPeriodo['codigo_periodo']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nombre Periodo:</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $dataPeriodo['nombre_periodo']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Total Semanas:</label>
            <input type="text" name="totalsem" class="form-control" value="<?php echo $dataPeriodo['total_semanas']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="fechainicio" class="form-label">Fecha final Periodo</label>
            <input type="date" class="form-control form-control sm" id="fechainicio" name="fechainicio" value="<?php echo $dataPeriodo['fecha_inicio']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="fechafinal" class="form-label">Fecha final Periodo</label>
            <input type="date" class="form-control form-control sm" id="fechafinal" name="fechafinal" value="<?php echo $dataPeriodo['fecha_fin']; ?>" required="true">
          </div>
          <div class="form-group">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select form-select-sm" id="estado" name="estado">
              <option value="<?php echo $dataPeriodo['estado']; ?>" selected><?php echo $dataPeriodo['estado']; ?></option>
              <?php
              if ($dataPeriodo=="INACTIVO"){ ?>
                            <option value="ACTIVO">INACTIVO</option>
              <?php
              }else{ ?>
                 <option value="INACTIVO">INACTIVO</option>
            </select>
            <?php }?>
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