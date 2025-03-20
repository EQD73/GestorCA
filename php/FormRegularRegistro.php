<?php
//session_start();

$tablam3 = $_SESSION['tablam3'];

include('conexion.php');
include('conexion2.php');

$query_micro = "SELECT * FROM $tablam3 WHERE id= '$codigoConsulta'";
$resultado_qm = pg_query($conexion, $query_micro);
$objConsulta = pg_fetch_object($resultado_qm);

?>

<form action="guardarRegularregistro.php" method="POST" id="pills-tabContent" name="pills-tabContent">
    <div class="tab-content">

        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Identificación de la asignatura</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Codigo asignatura</label>
                        <input type="text" class="form-control form-control sm" id="CodigoCurso" name="CodigoCurso" value="<?php echo $objConsulta->codigo_asignatura; ?>" readonly>
                    </div>
                    <input type="hidden" class="form-control form-control sm" id="CodigoCur" name="CodigoCur">
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Nombre de la asignatura</label>
                        <input type="text" class="form-control form-control sm" id="NombreCurso" name="NombreCurso" value="<?php echo $objConsulta->nombre_asignatura; ?>"readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Grupo</label>
                        <input type="text" class="form-control form-control sm" id="grupo" name="grupo" value="<?php echo $objConsulta->grupo; ?>" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Semestre</label>
                        <input type="text" class="form-control form-control sm" id="semestre" name="semestre" value="<?php echo $objConsulta->semestre; ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Código del Programa</label>
                        <input type="text" class="form-control form-control sm" id="CodigoPrograma" name="CodigoPrograma" value="<?php echo $objConsulta->codigo_programa; ?>" readonly>
                    </div>

                    <input type="hidden" class="form-control form-control sm" id="CodProg" name="CodProg">

                    <div class="col-md-8 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Programa</label>
                        <input type="text" class="form-control form-control sm" id="NombreProg" name="NombreProg" value="<?php echo $objConsulta->nombre_programa; ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Código del docente</label>
                        <input type="text" class="form-control form-control sm" id="CodigoDocente" name="CodigoDocente" value="<?php echo $objConsulta->codigo_docente; ?>" readonly>
                    </div>

                    <input type="hidden" class="form-control form-control sm" id="id_registro" name="id_registro" value="<?php echo $codigoConsulta?>">

                    <div class="col-md-8 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Docente</label>
                        <input type="text" class="form-control form-control sm" id="NomDocente" name="NomDocente" value="<?php echo $objConsulta->nombre_docente; ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab" tabindex="0">
            <div class="row" id="pills-2cont">

            </div>
            <div class="row">
                <div class="col-md-12 mt-2"></div>
            </div>
            <div class="text-center">
                <button class="btn btn-danger" id="BtnGuardar" type="submit">Guardar</button>
            </div>
        </div>
    </div>

</form>