<form action="guardarmicro.php" method="POST" id="pills-tabContent" name="pills-tabContent">
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
                        <h6>Identificación del Curso</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">

                        <label for="formGroup" class="form-label">Codigo del Curso</label>
                        <select class="form-select form-select-sm" id="CodigoCurso" name="CodigoCurso" autofocus>
                            <option value="" data-codigo="" data-nombre="" data-grupo="" selected>Escoger Opción</option>
                            <?php

                            while ($obj = pg_fetch_object($resultado_qa)) { $codprog=$obj->codigo_programa; ?>
                                <option value="" data-codigo="<?php echo $obj->codigo_asignatura; ?>" data-nombre="<?php echo $obj->nom_asignatura; ?>" data-grupo="<?php echo $obj->grupo; ?>" data-semestre="<?php echo $obj->semestre; ?>" data-codfacul="<?php echo $obj->codigo_facultad; ?>" data-nomfacul="<?php echo $obj->nombre_facultad; ?>" data-codprog="<?php echo $obj->codigo_programa; ?>" data-nomprog="<?php echo $obj->nombre_programa; ?>" data-cred="<?php echo $obj->creditos; ?>" data-nomdocente="<?php echo $obj->nomcompleto; ?>" data-codper="<?php echo $codperiodo; ?>"><?php echo $codcurso = $obj->codigo_asignatura;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "  |  ";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo $nomasig = $obj->nom_asignatura;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "  |  ";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo $codgrupo = $obj->grupo; ?></option>

                            <?php

                            }

                            ?>

                        </select>
                    </div>


                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Curso</label>
                        <input type="text" class="form-control form-control sm" id="NombreCurso" name="NombreCurso" readonly>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Grupo</label>
                        <input type="text" class="form-control form-control sm" id="grupo" name="grupo" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Fecha de actualización</label>
                        <input type="date" class="form-control form-control sm" id="fechaupdate" name="fechaupdate" placeholder="ingresar Fecha de Actualización">
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Código de Facultad</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="CodigoFacultad" id="CodigoFacultad">
                            <option value="" data-codigo="" data-nombre="" selected>Escoger Opción</option>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qf)) { ?>
                                <option value="<?php echo $obj->codigo_facultad; ?>" data-codigo="<?php echo $obj->codigo_facultad; ?>" data-nombre="<?php echo $obj->nombre_facultad; ?>"><?php echo $codfac = $obj->codigo_facultad;
                                                                                                                                                                                            echo "  |  ";
                                                                                                                                                                                            echo $nombrefac = $obj->nombre_facultad; ?></option>
                            <?php
                            }
                            ?>
                        </select>

                    </div>
                    <input type="hidden" class="form-control form-control sm" id="CodFacul" name="CodFacul">
                    <input type="hidden" class="form-control form-control sm" id="NomDocente" name="NomDocente">

                    <div class="col-md-5 mt-2">
                        <label for="formGroup" class="form-label">Nombre de Facultad</label>
                        <input type="text" class="form-control form-control sm" id="NombreFacul" name="NombreFacul" readonly>
                    </div>

                    <div class="col-md-1 mt-2">
                        <label for="formGroup" class="form-label">Semestre</label>
                        <input type="text" class="form-control form-control sm" id="semestre" name="semestre" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Codigo</label>
                        <input type="text" class="form-control form-control sm" id="CodigoCur" name="CodigoCur" readonly>
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Programa al que le tributa</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="CodigoPrograma" name="CodigoPrograma">
                            <option value="" data-codigo="" data-nombre="" selected>Escoger Opción</option>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qp)) { ?>
                                <option value="<?php echo $obj->codigo_programa; ?>" data-codigop="<?php echo $obj->codigo_programa; ?>" data-nombrep="<?php echo $obj->nombre_programa; ?>"><?php echo $obj->codigo_programa;
                                                                                                                                                                                                echo "  |  ";
                                                                                                                                                                                                echo $obj->nombre_programa; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" class="form-control form-control sm" id="CodProg" name="CodProg">
                    <input type="hidden" class="form-control form-control sm" id="Codper" name="Codper">

                    <div class="col-md-4 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Programa</label>
                        <input type="text" class="form-control form-control sm" id="NombreProg" name="NombreProg" readonly>
                    </div>

                    <div class="col-md-1 mt-2">
                        <label for="formGroup" class="form-label">Créditos</label>
                        <input type="text" class="form-control form-control sm" id="creditos" name="creditos" placeholder="" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Total Sem. Periodo</label>
                        <input type="text" class="form-control form-control sm" id="totalsem" name="totalsem" value="16" readonly>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2">
                        <label for="formGroup" class="form-label">Requisitos</label>
                        <select class="form-select" name="requisitos[]" multiple id="requisitos" data-placeholder="Escoger Opción">

                            <?php
                            foreach ($result as $val) { ?>
                                <option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
                            <?php
                            }


                            while ($obj = pg_fetch_object($resultado_qa2)) { ?>
                                <option value="<?php echo $obj->codigo_asignatura;
                                                echo " - ";
                                                echo $obj->nom_asignatura; ?>"><?php echo $obj->codigo_asignatura;
                                                                                echo " - ";
                                                                                echo $obj->nom_asignatura;
                                                                                ?></option>

                            <?php

                            }

                            ?>

                        </select>
                    </div>
                    <!-- <input type="text" class="form-control form-control sm" id="requisitos" name="requisitos" placeholder="ingrese Requisitos"> -->

                </div>

                <div class="row">
                    <div class="col-md-12 mt-2 p-3 bg-danger bg-opacity-10 border border-danger border-start-0 rounded-end">
                        <label for="formGroup" class="form-label">Nivel de formación</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="NivelRadioOptions" id="NivelRadio1" value="Tecnológico" checked="true">
                            <label class="form-check-label" for="NivelRadio1">Tecnológico</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="NivelRadioOptions" id="NivelRadio2" value="Profesional">
                            <label class="form-check-label" for="NivelRadio2">Profesional</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="NivelRadioOptions" id="NivelRadio3" value="Especialización">
                            <label class="form-check-label" for="NivelRadio3">Especialización</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2 p-3 bg-secondary bg-opacity-10 border border-seconday border-start-0 rounded-end">
                        <label for="formGroup" class="form-label">Area de formación</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio1" value="Básica" checked="true">
                            <label class="form-check-label" for="AreaRadio1">Básica</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio2" value="Específica">
                            <label class="form-check-label" for="AreaRadio2">Específica</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio3" value="Socio-Humanística">
                            <label class="form-check-label" for="AreaRadio3">Socio-Humanística</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio4" value="Flexible">
                            <label class="form-check-label" for="AreaRadio4">Flexible</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio5" value="Investigación">
                            <label class="form-check-label" for="AreaRadio5">Investigación</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2 p-3 bg-danger bg-opacity-10 border border-danger border-start-0 rounded-end">
                        <label for="formGroup" class="form-label">Tipo de Curso</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="TipoRadioOptions" id="TipoRadio1" value="Teórico" checked="true">
                            <label class="form-check-label" for="TipoRadio1">Teórico</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="TipoRadioOptions" id="TipoRadio2" value="Práctico">
                            <label class="form-check-label" for="TipoRadio2">Práctico</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="TipoRadioOptions" id="TipoRadio3" value="Teórico-Práctico">
                            <label class="form-check-label" for="TipoRadio3">Teórico-Práctico</label>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2 p-3 bg-danger bg-opacity-10 border border-danger border-start-0 rounded-end">
                        <label for="formGroup" class="form-label">Modalidad</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ModalRadioOptions" id="ModalRadio1" value="Presencial" checked="true">
                            <label class="form-check-label" for="ModalRadio1">Presencial</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ModalRadioOptions" id="ModalRadio2" value="Virtual">
                            <label class="form-check-label" for="ModalRadio2">Virtual</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ModalRadioOptions" id="ModalRadio3" value="Mixta">
                            <label class="form-check-label" for="ModalRadio3">Mixta</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-md-6 mt-2 p-3 bg-secondary bg-opacity-10 border border-secondary border-start-0 rounded-end">
                        <label for="formGroup" class="form-label">Horas de trabajo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="HorasRadioOptions" id="HorasRadio1" value="Presencial" checked="true">
                            <label class="form-check-label" for="HorasRadio1">Presencial</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="HorasRadioOptions" id="HorasRadio2" value="Virtual">
                            <label class="form-check-label" for="HorasRadio2">Virtual</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="HorasRadioOptions" id="HorasRadio3" value="Indepediente">
                            <label class="form-check-label" for="HorasRadio3">Independiente</label>
                        </div>
                    </div> -->
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Total Horas Trabajo</label>
                        <input type="text" class="form-control form-control sm" id="tht" name="tht" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Total H.T. Indepen.</label>
                        <input type="text" class="form-control form-control sm" id="thti" name="thti" onkeyup="sumar();">
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="formGroup" class="form-label">Total H.T. Presen.</label>
                        <input type="text" class="form-control form-control sm" id="thtp" name="thtp" onkeyup="sumar();">
                    </div>
                </div>
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger mt-2">
                        <h6>Descripción</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <span class="badge text-bg-danger mt-2">
                            <h6>Descripción de la intención formativa del curso</h6>
                        </span>
                        <textarea class="form-control" id="DescripcionTextarea1" name="DescripcionTextarea1" placeholder="Descripcion de la intencion formativa" rows="6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <span class="badge text-bg-danger mt-2">
                            <h6>Resultados de aprendizaje del programa a los que apunta la asignatura</h6>
                        </span>
                        <textarea class="form-control" id="ResultadosTextarea1" name="ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="6"></textarea>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Metodología</h6>
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Estrategia Pedagógica y Didactica</label>
                        <textarea class="form-control" id="EstrategiaTextarea1" name="EstrategiaTextarea1" placeholder="Estrategia pedagogica y didactica" rows="8"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Recursos</label>
                        <textarea class="form-control" id="RecursosTextarea1" name="RecursosTextarea1" placeholder="Recursos" rows="8"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2"></div>
                </div>
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Evaluación</h6>
                    </span>
                </div>
                <div class="row">
                    <h5><span class="badge bg-danger">Momentos de Evaluación</span></h5>
                </div>
                <div class="row">
                    <table class="table table-bordered border-danger">
                        <thead>
                            <tr>
                                <th class="th-sm text-center">Momento de evaluación</th>
                                <th class="th-sm ancho-columna text-center">Porcentaje de actividades formativas (talleres, quices, actividades de seguimiento: trabajos en clases, trabajo independiente y trabajo final)</th>
                                <th class="th-sm text-center">Porcentaje de actividad final de corte</th>
                                <th class="th-sm text-center">Porcentaje Por corte</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qe)) { ?>

                                <tr>
                                    <td><?php echo $obj->momento; ?></td>
                                    <td><?php echo $obj->por_actividades; ?></td>
                                    <td><?php echo $obj->por_actfinal; ?></td>
                                    <td><?php echo $obj->por_corte; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                </div>
                <div class="row">
                    <h5><span class="badge bg-danger">Escala de valoración de los niveles de desempeño</span></h5>
                </div>
                <div class="row">
                    <table class="table table-bordered border-danger">
                        <thead>
                            <tr>
                                <th class="th-sm text-center" colspan="4">Niveles de desempeño</th>
                            </tr>
                            <tr>
                                <th class="th-sm text-center">Nivel 1</th>
                                <th class="th-sm text-center">Nivel 2</th>
                                <th class="th-sm text-center">Nivel 3</th>
                                <th class="th-sm text-center">Nivel 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qn)) { ?>

                                <tr>
                                    <td><?php echo $obj->nivel1; ?></td>
                                    <td><?php echo $obj->nivel2; ?></td>
                                    <td><?php echo $obj->nivel3; ?></td>
                                    <td><?php echo $obj->nivel4; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Unidades de Formación</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <h4>UNIDAD 1.</h4>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Presenciales:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad1HP" name="Unidad1HP" placeholder="Horas Presenciales">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad1HI" name="Unidad1HI" placeholder="Horas Independientes">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad1CS" name="Unidad1CS" placeholder="Corte/Semanas">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U1ResultadosTextarea1" name="U1ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="10"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U1ContenidosTextarea1" name="U1ContenidosTextarea1" placeholder="Contenidos" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U1ActividadesTextarea1" name="U1ActividadesTextarea1" placeholder="Actividades Formativas" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U1SistemaTextarea1" name="U1SistemaTextarea1" placeholder="sistema de Evaluación" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Unidades de Formación</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <h4>UNIDAD 2.</h4>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Presenciales:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad2HP" name="Unidad2HP" placeholder="Horas Presenciales">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad2HI" name="Unidad2HI" placeholder="Horas Independientes">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad2CS" name="Unidad2CS" placeholder="Corte/Semanas">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U2ResultadosTextarea1" name="U2ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U2ContenidosTextarea1" name="U2ContenidosTextarea1" placeholder="Contenidos" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U2ActividadesTextarea1" name="U2ActividadesTextarea1" placeholder="Actividades Formativas" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U2SistemaTextarea1" name="U2SistemaTextarea1" placeholder="sistema de Evaluación" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Unidades de Formación</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <h4>UNIDAD 3.</h4>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Presenciales:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad3HP" name="Unidad3HP" placeholder="Horas Presenciales">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad3HI" name="Unidad3HI" placeholder="Horas Independientes">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad3CS" name="Unidad3CS" placeholder="Corte/Semanas">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U3ResultadosTextarea1" name="U3ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U3ContenidosTextarea1" name="U3ContenidosTextarea1" placeholder="Contenidos" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U3ActividadesTextarea1" name="U3ActividadesTextarea1" placeholder="Actividades Formativas" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U3SistemaTextarea1" name="U3SistemaTextarea1" placeholder="sistema de Evaluación" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-6" role="tabpanel" aria-labelledby="pills-6-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Unidades de Formación</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <h4>UNIDAD 4.</h4>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Presenciales:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad4HP" name="Unidad4HP" placeholder="Horas Presenciales">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad4HI" name="Unidad4HI" placeholder="Horas Independientes">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad4CS" name="Unidad4CS" placeholder="Corte/Semanas">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U4ResultadosTextarea1" name="U4ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U4ContenidosTextarea1" name="U4ContenidosTextarea1" placeholder="Contenidos" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U4ActividadesTextarea1" name="U4ActividadesTextarea1" placeholder="Actividades Formativas" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U4SistemaTextarea1" name="U4SistemaTextarea1" placeholder="sistema de Evaluación" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-7" role="tabpanel" aria-labelledby="pills-7-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Unidades de Formación</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <h4>UNIDAD 5.</h4>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Presenciales:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad5HP" name="Unidad5HP" placeholder="Horas Presenciales">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad5HI" name="Unidad5HI" placeholder="Horas Independientes">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad5CS" name="Unidad5CS" placeholder="Corte/Semanas">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U5ResultadosTextarea1" name="U5ResultadosTextarea1" placeholder="Resultados de aprendizaje" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U5ContenidosTextarea1" name="U5ContenidosTextarea1" placeholder="Contenidos" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U5ActividadesTextarea1" name="U5ActividadesTextarea1" placeholder="Actividades Formativas" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U5SistemaTextarea1" name="U5SistemaTextarea1" placeholder="sistema de Evaluación" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-8" role="tabpanel" aria-labelledby="pills-8-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <span class="badge text-bg-danger">
                        <h6>Proyecto Integrador</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control form-control sm" id="NombreProy" name="NombreProy" placeholder="ingresar Nombre del proyecto">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Objetivo General del proyecto</label>
                        <textarea class="form-control" id="AsignaturaProy" name="AsignaturaProy" placeholder="Objetivo General" rows="6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Objetivos especificos del proyecto</label>
                        <textarea class="form-control" id="TematicasProy" name="TematicasProy" placeholder="Objetivos especificos" rows="6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Resultados esperados del proyecto</label>
                        <textarea class="form-control" id="AccionesProy" name="AccionesProy" placeholder="ingresar Resultados esperados" rows="6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2"></div>
                </div>
                <div class="row">
                    <span class="badge text-bg-danger">
                        <h6>Referencias</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Bibliografía existente en la biblioteca institucional</label>
                        <textarea class="form-control" id="ReferBiblio" name="ReferBiblio" placeholder="ingresar Bibliografia existente" rows="6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Otra bibliografía</label>
                        <textarea class="form-control" id="ReferOtra" name="ReferOtra" placeholder="ingresar Otra Bibliografia" rows="6"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Referencias en inglés</label>
                        <textarea class="form-control" id="ReferIngles" name="ReferIngles" placeholder="ingresar Referencias en Ingles" rows="6"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label for="formGroup" class="form-label">Webgrafía y bases de datos</label>
                            <textarea class="form-control" id="ReferWebgrafia" name="ReferWebgrafia" placeholder="ingresar Webgrafía y bases de datos" rows="6"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <div class="tab-pane fade" id="pills-9" role="tabpanel" aria-labelledby="pills-9-tab" tabindex="0">
                    <div class="container">
                        <div class="row">
                            <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                            <span class="badge text-bg-danger">
                                <h6>Validación</h6>
                            </span>
                        </div>
                        <?php


                        if ($codigo_rol == '2') { ?>
                            <div class="row border border-danger rounded mx-md-n5">
                                <div class="col px-md-6 my-2">
                                    <div class="p-3 border bg-light">
                                        <label for="formGroup" class="form-label">Coordinador/director de programa</label>
                                        <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                            <option value="" selected>Escoger Opción</option>
                                            <?php
                                            $query_programas = "SELECT * FROM sistema.programas WHERE codigo_programa='$codprog'";
                                            $resultado_qp1 = pg_query($conexion, $query_programas);

                                            while ($obj = pg_fetch_object($resultado_qp1)) { ?>
                                                <option value="<?php echo $obj->nom_coordinador; ?>"><?php echo $obj->nom_coordinador; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col px-md-6 my-2">
                                    <div class="p-3 border bg-light">
                                        <label for="formGroup" class="form-label">Vicerectoria Académica</label>
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
                        if ($codigo_rol == '4') { ?>
                                <div class="row border border-danger rounded mx-md-n5">
                                    <div class="col px-md-6 my-2">
                                        <div class="p-3 border bg-light">
                                            <label for="formGroup" class="form-label">Coordinador/director de programa</label>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                                <option value="" selected>Escoger Opción</option>
                                                <?php
                                               $query_programas = "SELECT * FROM sistema.programas WHERE codigo_programa='$codprog'";
                                               $resultado_qp1 = pg_query($conexion, $query_programas);
   
                                               while ($obj = pg_fetch_object($resultado_qp1)) { ?>
                                                   <option value="<?php echo $obj->nom_coordinador; ?>"><?php echo $obj->nom_coordinador; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col px-md-6 my-2">
                                        <div class="p-3 border bg-light">
                                            <label for="formGroup" class="form-label">Vicerectoria Académica</label>
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
                            if ($codigo_rol == '5') { ?>
                                    <div class="row border border-danger rounded mx-md-n5">
                                        <div class="col px-md-6 my-2">
                                            <div class="p-3 border bg-light">
                                                <label for="formGroup" class="form-label">Coordinador/director de programa</label>
                                                <select class="form-select form-select-sm disabled" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                                    <option value="" selected>Escoger Opción</option>
                                                    <?php
                                                    $query_programas = "SELECT * FROM sistema.programas WHERE codigo_programa='$codprog'";
                                                    $resultado_qp1 = pg_query($conexion, $query_programas);
        
                                                    while ($obj = pg_fetch_object($resultado_qp1)) { ?>
                                                        <option value="<?php echo $obj->nom_coordinador; ?>"><?php echo $obj->nom_coordinador; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col px-md-6 my-2">
                                            <div class="p-3 border bg-light">
                                                <label for="formGroup" class="form-label">Vicerectoria Académica</label>
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
                                if ($codigo_rol == '1') { ?>
                                        <div class="row border border-danger rounded mx-md-n5">
                                            <div class="col px-md-6 my-2">
                                                <div class="p-3 border bg-light">
                                                    <label for="formGroup" class="form-label">Coordinador/director de programa</label>
                                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="Validador1" name="Validador1">
                                                        <option value="" selected>Escoger Opción</option>
                                                        <?php
                                                        $query_programas = "SELECT * FROM sistema.programas WHERE codigo_programa='$codprog'";
                                                        $resultado_qp1 = pg_query($conexion, $query_programas);
            
                                                        while ($obj = pg_fetch_object($resultado_qp1)) { ?>
                                                            <option value="<?php echo $obj->nom_coordinador; ?>"><?php echo $obj->nom_coordinador; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col px-md-6 my-2">
                                                <div class="p-3 border bg-light">
                                                    <label for="formGroup" class="form-label">Vicerectoria Académica</label>
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
</form>