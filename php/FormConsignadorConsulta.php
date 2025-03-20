<?php

//session_start();

$tablam2 = $_SESSION['tablam2'];



include('conexion.php');
//include('conexion2.php');

$dbconn2 = pg_connection_reset($conexion);

$query_consigna = "SELECT * FROM $tablam2 WHERE id= '$codigoConsulta'";
$resultado_qc = pg_query($conexion, $query_consigna);
$objConsulta = pg_fetch_object($resultado_qc);

$query_consigna2 = "SELECT * FROM $tablam2 WHERE id= '$codigoConsulta'";
$resultado_qc2 = pg_query($conexion, $query_consigna2);
$objConsulta2 = pg_fetch_object($resultado_qc2);


?>


<form action="guardarconsignadorConsulta.php" method="POST" id="pills-tabContent" name="pills-tabContent">
    <div class="tab-content">
        <div class="row">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-danger btn-ms" id="BtnGuardar" type="submit" data-toggle="tooltip" data-placement="top" title="Guardar"><i data-feather="save" width="20"></i> Guardar</button>
                <!-- <a href="Report_microcurriculo" class="btn btn-success btn-ms" role="button" aria-pressed="true" data-toggle="tooltip" data-placement="top" title="Imprimir PDF"><i class="fa-regular fa-file-pdf"></i></a> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2"></div>
        </div>
        <hr class="hr hr-blurry" />
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
                        <input type="text" class="form-control form-control-sm" id="CodigoCurso" name="CodigoCurso" value="<?php echo $objConsulta->codigo_asignatura; ?>" readonly>

                    </div>
                    <input type="hidden" class="form-control form-control sm" id="id_consigna" name="id_consigna" value="<?php echo $codigoConsulta; ?>">
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Nombre de la asignatura</label>
                        <input type="text" class="form-control form-control sm" id="NombreCurso" name="NombreCurso" value="<?php echo $objConsulta->nombre_asignatura; ?>" readonly>
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
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Código del Programa</label>
                        <input type="text" class="form-control form-control sm" id="CodigoPrograma" name="CodigoPrograma" value="<?php echo $objConsulta->codigo_programa; ?>" readonly autofocus>
                    </div>

                    <div class="col-md-9 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Programa</label>
                        <input type="text" class="form-control form-control sm" id="NombreProg" name="NombreProg" value="<?php echo $objConsulta->nombre_programa; ?>" readonly>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Código del docente</label>
                        <input type="text" class="form-control form-control sm" id="CodigoDocente" name="CodigoDocente" value="<?php echo $objConsulta->codigo_docente; ?>" readonly>
                    </div>

                    <div class="col-md-8 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Docente</label>
                        <input type="text" class="form-control form-control sm" id="NomDocente" name="NomDocente" value="<?php echo $objConsulta->nombre_docente; ?>" readonly>
                    </div>
                </div>


                <div class="row">
                    <span class="badge text-bg-danger mt-2">
                        <h6>Resultados de aprendizaje del programa</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <textarea class="form-control" id="ResultadosTextarea1" name="ResultadosTextarea1" rows="7"><?php echo $objConsulta->resultados_aprendizaje; ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <span class="badge text-bg-danger mt-2">
                        <h6>Intensidad Horaria Semanal</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Horas Trabajo Teórico Semanal:</label>
                        <input type="text" class="form-control form-control sm" id="HorasTTS" name="HorasTTS" value="<?php echo $objConsulta->htts; ?>">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Horas Trabajo Práctico Semanal:</label>
                        <input type="text" class="form-control form-control sm" id="HorasTPS" name="HorasTPS" value="<?php echo $objConsulta->htps; ?>">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Horas Trabajo Independiente Semanal:</label>
                        <input type="text" class="form-control form-control sm" id="HorasTIS" name="HorasTIS" value="<?php echo $objConsulta->htis; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab" tabindex="0">

        </div>
        <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Validación</h6>
                    </span>
                </div>

                <?php
                    if ($codigo_rol == '2') { ?> <div class="row border border-danger rounded mx-md-n5">
                    <div class="col px-md-6 my-2">
                        <div class="p-3 border bg-light">
                            <label for="formGroup" class="form-label">Validación 1</label>
                            <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                <option value="<?php echo $objConsulta2->validador1; ?>" selected><?php echo $objConsulta2->validador1; ?></option>
                                <?php
                                while ($obj = pg_fetch_object($resultado_qu2)) { ?>
                                    <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col px-md-6 my-2">
                        <div class="p-3 border bg-light">
                            <label for="formGroup" class="form-label">Validación 2</label>
                            <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador2" name="Validador2">
                                <option value="<?php echo $objConsulta2->validador2; ?>" selected><?php echo $objConsulta2->validador2; ?></option>
                                <?php
                                while ($obj = pg_fetch_object($resultado_qu3)) { ?>
                                    <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php }
                    if ($codigo_rol == '4') { ?>
                    <div class="row border border-danger rounded mx-md-n5">
                        <div class="col px-md-6 my-2">
                            <div class="p-3 border bg-light">
                                <label for="formGroup" class="form-label">Validación 1</label>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                    <option value="<?php echo $objConsulta2->validador1; ?>" selected><?php echo $objConsulta2->validador1; ?></option>
                                    <?php
                                    while ($obj = pg_fetch_object($resultado_qu2)) { ?>
                                        <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col px-md-6 my-2">
                            <div class="p-3 border bg-light">
                                <label for="formGroup" class="form-label">Validación 2</label>
                                <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador2" name="Validador2">
                                    <option value="<?php echo $objConsulta2->validador2; ?>" selected><?php echo $objConsulta2->validador2; ?></option>
                                    <?php
                                    while ($obj = pg_fetch_object($resultado_qu3)) { ?>
                                        <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php }
                    if ($codigo_rol == '5') { ?>
                        <div class="row border border-danger rounded mx-md-n5">
                            <div class="col px-md-6 my-2">
                                <div class="p-3 border bg-light">
                                    <label for="formGroup" class="form-label">Validación 1</label>
                                    <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                        <option value="<?php echo $objConsulta2->validador1; ?>" selected><?php echo $objConsulta2->validador1; ?></option>
                                        <?php
                                        while ($obj = pg_fetch_object($resultado_qu2)) { ?>
                                            <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col px-md-6 my-2">
                                <div class="p-3 border bg-light">
                                    <label for="formGroup" class="form-label">Validación 2</label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador2" name="Validador2">
                                        <option value="<?php echo $objConsulta2->validador2; ?>" selected><?php echo $objConsulta2->validador2; ?></option>
                                        <?php
                                        while ($obj = pg_fetch_object($resultado_qu3)) { ?>
                                            <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php }
                    if ($codigo_rol == '1') { ?>
                            <div class="row border border-danger rounded mx-md-n5">
                                <div class="col px-md-6 my-2">
                                    <div class="p-3 border bg-light">
                                        <label for="formGroup" class="form-label">Validación 1</label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                            <option value="<?php echo $objConsulta2->validador1; ?>" selected><?php echo $objConsulta2->validador2; ?></option>
                                            <?php
                                            while ($obj = pg_fetch_object($resultado_qu2)) { ?>
                                                <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col px-md-6 my-2">
                                    <div class="p-3 border bg-light">
                                        <label for="formGroup" class="form-label">Validación 2</label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador2" name="Validador2">
                                            <option value="<?php echo $objConsulta2->validador2; ?>" selected><?php echo $objConsulta2->validador2; ?></option>
                                            <?php
                                            while ($obj = pg_fetch_object($resultado_qu3)) { ?>
                                                <option value="<?php echo $obj->nomcompleto; ?>"><?php echo $obj->nomcompleto; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-2"></div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-danger" id="BtnGuardar" type="submit">Guardar</button>
                            </div>
                        </div>
                    </div>
            </div>
</form>