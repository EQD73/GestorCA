<?php

include("conexion.php");
// select de tabla asignaturas

$query_asignaturas = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC, grupo ASC ";
$resultado_qac = pg_query($conexion, $query_asignaturas);
$num2 = pg_num_rows($resultado_qac);
?>

<!-- Modal Consultar Registro-->
<div class="modal fade" id="modal-impmicro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Informe por asignaturas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="ImprimirConsignador.php" target="_blank">
             <div class="modal-body">
                    <div class="row">
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="RadioImpMicro" id="flexRadioOp1" checked>
                        <label class="form-check-label" for="flexRadioOp1">
                            Una Asignatura
                        </label>
                     </div>
                     <div>
                        <label for="formGroup" class="form-label">Nombre del Curso</label>
                        <select class="form-select form-select-sm" id="CodigoConsultaCurso" name="CodigoConsultaCurso">
                            <option value="" data-codigo="" data-nombre="" data-grupo="" selected>Escoger Opción</option>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qac)) { ?>
                                <option value="" data-codigo="<?php echo $obj->codigo_asignatura; ?>" data-grupo="<?php echo $obj->grupo; ?>"><?php echo $codcurso = $obj->codigo_asignatura;
                                                                                    echo "  |  ";
                                                                                    echo $nomasig = $obj->nom_asignatura;
                                                                                    echo "  |  ";
                                                                                    echo $codgrupo = $obj->grupo; ?></option>

                             <?php
                             }
                            ?>
                        </select>
                     </div>
                     <input type="hidden" class="form-control form-control sm" id="CodCur" name="CodCur">

                     <div class="col-md-3 mt-2">
                            <label for="formGroup" class="form-label">Grupo</label>
                            <input type="text" class="form-control form-control sm" id="grupo" name="grupo">
                     </div>
                    </div>
                    <div class="row">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="RadioImpMicro" id="flexRadioOp2" >
                        <label class="form-check-label" for="flexRadioOp2">
                            Todas las asignaturas
                        </label>
                        <input type="hidden" class="form-control form-control sm" id="CodCur2" name="CodCur2">
                    </div>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Imprimir</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
        document.getElementById('CodigoConsultaCurso').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada 
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los in */
            var elCode = document.getElementById('CodigoConsultaCurso');
            //var elName = document.getElementById('NombreCurso');
            var elGroup = document.getElementById('grupo');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            //elName.value = mData.nombre;
            elGroup.value = mData.grupo;
        };
</script>         -->