<form action="guardarconsignador.php" method="POST" id="pills-tabContent" name="pills-tabContent">
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
                        <select class="form-select form-select-sm" id="CodigoCurso" name="CodigoCurso" autofocus>
                            <option value="" data-codigo="" data-nombre="" data-grupo="" selected>Escoger Opción</option>
                            <?php

                            while ($obj = pg_fetch_object($resultado_qasig)) { ?>


                                <option value="" data-codigo="<?php echo $obj->codigo_asignatura; ?>" data-nombre="<?php echo $obj->nom_asignatura; ?>" data-grupo="<?php echo $obj->grupo; ?>" data-semestre="<?php echo $obj->semestre; ?>" data-codprog="<?php echo $obj->codigo_programa; ?>" data-nomprog="<?php echo $obj->nombre_programa; ?>" data-cred="<?php echo $obj->creditos; ?>" data-coddocente="<?php echo $obj->codigo_docente; ?>" data-nomdocente="<?php echo $obj->nomcompleto; ?>"><?php echo $codcurso = $obj->codigo_asignatura;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo "  |  ";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $nomasig = $obj->nom_asignatura;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo "  |  ";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $codgrupo = $obj->grupo; ?></option>
                            <?php
                                echo $obj->codigo_asignatura;
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" class="form-control form-control sm" id="CodigoCur" name="CodigoCur">

                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Nombre de la asignatura</label>
                        <input type="text" class="form-control form-control sm" id="NombreCurso" name="NombreCurso" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Grupo</label>
                        <input type="text" class="form-control form-control sm" id="grupo" name="grupo" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Semestre</label>
                        <input type="text" class="form-control form-control sm" id="semestre" name="semestre">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Código del Programa</label>
                        <input type="text" class="form-control form-control sm" id="CodigoPrograma" name="CodigoPrograma" readonly>
                    </div>

                    <!-- <input type="hidden" class="form-control form-control sm" id="CodProg" name="CodProg"> -->

                    <div class="col-md-9 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Programa</label>
                        <input type="text" class="form-control form-control sm" id="NombreProg" name="NombreProg" readonly>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Código del docente</label>
                        <input type="text" class="form-control form-control sm" id="CodigoDocente" name="CodigoDocente" readonly>
                    </div>

                    <input type="hidden" class="form-control form-control sm" id="CodDocente" name="CodDocente">

                    <div class="col-md-8 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Docente</label>
                        <input type="text" class="form-control form-control sm" id="NomDocente" name="NomDocente" readonly>
                    </div>
                </div>


                <div class="row">
                    <span class="badge text-bg-danger mt-2">
                        <h6>Resultados de aprendizaje del programa</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <textarea class="form-control" id="ResultadosTextarea1" name="ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="7"></textarea>
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
                        <input type="text" class="form-control form-control sm" id="HorasTTS" name="HorasTTS" placeholder="Horas Trabajo teórico">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Horas Trabajo Práctico Semanal:</label>
                        <input type="text" class="form-control form-control sm" id="HorasTPS" name="HorasTPS" placeholder="Horas Trabajo Práctico">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Horas Trabajo Independiente Semanal:</label>
                        <input type="text" class="form-control form-control sm" id="HorasTIS" name="HorasTIS" placeholder="Horas Trabajo Independiente">
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab" tabindex="0">
            <div class="row" id="pills-2c">

            </div>
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
                
                
                if ($codigo_rol == '2') {?> 
                <div class="row border border-danger rounded mx-md-n5">
                    <div class="col px-md-6 my-2">
                        <div class="p-3 border bg-light">
                            <label for="formGroup" class="form-label">Validación 1</label>
                            <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                <option value="" selected>Escoger Opción</option>
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
                                <option value="" selected>Escoger Opción</option>
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
                    if ($codigo_rol=='4') { ?>
                    <div class="row border border-danger rounded mx-md-n5">
                    <div class="col px-md-6 my-2">
                        <div class="p-3 border bg-light">
                            <label for="formGroup" class="form-label">Validación 1</label>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                <option value="" selected>Escoger Opción</option>
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
                                <option value="" selected>Escoger Opción</option>
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
                    if ($codigo_rol=='5') { ?>
                    <div class="row border border-danger rounded mx-md-n5">
                    <div class="col px-md-6 my-2">
                        <div class="p-3 border bg-light">
                            <label for="formGroup" class="form-label">Validación 1</label>
                            <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                <option value="" selected>Escoger Opción</option>
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
                                <option value="" selected>Escoger Opción</option>
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
                    if ($codigo_rol=='1'){?>
                    <div class="row border border-danger rounded mx-md-n5">
                    <div class="col px-md-6 my-2">
                        <div class="p-3 border bg-light">
                            <label for="formGroup" class="form-label">Validación 1</label>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                <option value="" selected>Escoger Opción</option>
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
                                <option value="" selected>Escoger Opción</option>
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