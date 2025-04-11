<!-- Ventana modal para eliminar -->
<div class="modal fade" id="deleteChildresn<?php echo $dataEstra['codigo_estrategia']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          ¿Realmente deseas eliminar a ?
        </h4>
      </div>

      <div class="modal-body">
        <strong style="text-align: center !important">
          <?php echo $dataEstra['codigo_estrategia'];
          echo " - ";
          echo $dataEstra['nombre_estrategia']; ?>

        </strong>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger btnBorrar" data-dismiss="modal" id="<?php echo $dataEstra['codigo_estrategia']; ?>">Borrar</button>
      </div>

    </div>
  </div>
</div>
<!---fin ventana eliminar--->