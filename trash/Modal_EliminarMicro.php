<?php
include('conexion.php');
// select de tabla asignaturas

$query_asignaturas2 = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC, grupo ASC ";
$resultado_qae = pg_query($conexion, $query_asignaturas2);
$num2e = pg_num_rows($resultado_qae);
?>
<!-- Modal Eliminar Registro-->
<!-- <div class="modal fade" id="modal-eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="RecibDeleteMicro.php">
                <div class="modal-body">
                    <label for="formGroup" class="form-label">Nombre del Curso</label>
                    <select class="form-select form-select-sm" id="CodigoEliminarCurso" name="CodigoEliminarCurso">
                        <option selected>Escoger Opción</option>
                        <?php
                        while ($obj = pg_fetch_object($resultado_qae)) { ?>
                            <option value="<?php echo $obj->codigo_asignatura; ?>"><?php echo $codcurso = $obj->codigo_asignatura;
                                                                                    echo "  |  ";
                                                                                    echo $nomasig = $obj->nom_asignatura;
                                                                                    echo "  |  ";
                                                                                    echo $codgrupo = $obj->grupo; ?></option>

                        <?php
                        }
                        ?>
                    </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
        </div>
    </div>
</div> -->