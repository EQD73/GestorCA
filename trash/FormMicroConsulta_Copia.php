<?php 
include('conexion.php');

$query_micro = "SELECT * FROM sistema.pr2022_m1 WHERE codigo_asignaturacurso= '$codigoConsultacurso'";
$resultado_qm = pg_query($conexion, $query_micro);
$objConsulta=pg_fetch_object($resultado_qm);
?>
<form action="guardarmicroUpdate1.php" method="POST" id="pills-tabContent" name="pills-tabContent">
    <div class="tab-content">
        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Identificación del Curso</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">

                        <label for="formGroup" class="form-label">Nombre del Curso</label>
                        <input type="text" class="form-control form-control-sm" id="CodigoCurso" name="CodigoCurso" value="<?php echo $objConsulta->nombre_asignatura; ?>" disabled>
                                            
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Fecha de actualización</label>
                        <input type="date" class="form-control form-control sm" id="fechaupdate" name="fechaupdate" value="<?php echo $objConsulta->fecha_actualizacion; ?>">
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Facultad a la que pertenece</label>
                        <input type="text" class="form-control form-control-sm" aria-label=".form-select-sm example" name="CodigoFacultad" value="<?php echo $objConsulta->nombre_facultad; ?>" disabled>
                                            
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Semestre</label>
                        <input type="text" class="form-control form-control-sm" id="semestre" name="semestre" value="<?php echo $objConsulta->semestre; ?>">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Codigo</label>
                        <input type="text" class="form-control form-control-sm" id="CodigoCur" name="CodigoCur" value="<?php echo $objConsulta->codigo_asignaturacurso; ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Programa al que le tributa</label>
                        <input type="text" class="form-control form-control-sm" aria-label=".form-select-sm example" name="CodigoPrograma" value="<?php echo $objConsulta->codigo_programa; ?>" disabled>
                       
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Créditos</label>
                        <input type="text" class="form-control form-control-sm" id="creditos" name="creditos" value="<?php echo $objConsulta->creditos; ?>">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Requisitos</label>
                        <input type="text" class="form-control form-control-sm" id="requisitos" name="requisitos" value="<?php echo $objConsulta->requisitos; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Nivel de formación</label>
                        <div class="form-check form-check-inline">
                            
                            <input class="form-check-input" type="radio" name="NivelRadioOptions" id="NivelRadio1" <?php echo $objConsulta->nivel_formacion==='Tecnológico' ?  'checked' : '' ?> value="Tecnológico">
                            <label class="form-check-label" for="NivelRadio1">Tecnológico</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="NivelRadioOptions" id="NivelRadio2" <?php echo $objConsulta->nivel_formacion==='Profesional' ?  'checked' : '' ?> value="Profesional">
                            <label class="form-check-label" for="NivelRadio2">Profesional</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="NivelRadioOptions" id="NivelRadio3" <?php echo $objConsulta->nivel_formacion==='Especialización' ?  'checked' : '' ?> value="Especialización">
                            <label class="form-check-label" for="NivelRadio3">Especialización</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Area de formación</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio1"  <?php echo $objConsulta->area_formacion==='Básica' ?  'checked' : '' ?> value="Básica">
                            <label class="form-check-label" for="AreaRadio1">Básica</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio2" <?php echo $objConsulta->area_formacion==='Específica' ?  'checked' : '' ?>  value="Específica">
                            <label class="form-check-label" for="AreaRadio2">Específica</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio3" <?php echo $objConsulta->area_formacion==='Socio-Humanística' ?  'checked' : '' ?>  value="Socio-Humanística">
                            <label class="form-check-label" for="AreaRadio3">Socio-Humanística</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio4" <?php echo $objConsulta->area_formacion==='Flexible' ?  'checked' : '' ?>  value="Flexible">
                            <label class="form-check-label" for="AreaRadio4">Flexible</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="AreaRadioOptions" id="AreaRadio5" <?php echo $objConsulta->area_formacion==='Investigación' ?  'checked' : '' ?>  value="Investigación">
                            <label class="form-check-label" for="AreaRadio5">Investigación</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Tipo de Curso</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="TipoRadioOptions" id="TipoRadio1" <?php echo $objConsulta->tipo_curso==='Teórico' ?  'checked' : '' ?>  value="Teórico">
                            <label class="form-check-label" for="TipoRadio1">Teórico</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="TipoRadioOptions" id="TipoRadio2" <?php echo $objConsulta->tipo_curso==='Práctico' ?  'checked' : '' ?>  value="Práctico">
                            <label class="form-check-label" for="TipoRadio2">Práctico</label>  
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="TipoRadioOptions" id="TipoRadio3" <?php echo $objConsulta->tipo_curso==='Teórico-Práctico' ?  'checked' : '' ?>  value="Teórico-Práctico">
                            <label class="form-check-label" for="TipoRadio3">Teórico-Práctico</label>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Modalidad</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ModalRadioOptions" id="ModalRadio1"  <?php echo $objConsulta->modalidad==='Presencial' ?  'checked' : '' ?> value="Presencial">
                            <label class="form-check-label" for="ModalRadio1">Presencial</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ModalRadioOptions" id="ModalRadio2" <?php echo $objConsulta->modalidad==='Virtual' ?  'checked' : '' ?> value="Virtual">
                            <label class="form-check-label" for="ModalRadio2">Virtual</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ModalRadioOptions" id="ModalRadio3" <?php echo $objConsulta->modalidad==='Mixta' ?  'checked' : '' ?> value="Mixta">
                            <label class="form-check-label" for="ModalRadio3">Mixta</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Horas de trabajo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="HorasRadioOptions" id="HorasRadio1"  <?php echo $objConsulta->horas_trabajo==='Presencial' ?  'checked' : '' ?> value="Presencial">
                            <label class="form-check-label" for="HorasRadio1">Presencial</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="HorasRadioOptions" id="HorasRadio2" <?php echo $objConsulta->horas_trabajo==='Virtual' ?  'checked' : '' ?> value="Virtual">
                            <label class="form-check-label" for="HorasRadio2">Virtual</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="HorasRadioOptions" id="HorasRadio3" <?php echo $objConsulta->horas_trabajo==='Independiente' ?  'checked' : '' ?>  value="Indepediente">
                            <label class="form-check-label" for="HorasRadio3">Independiente</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--<h2><span class="badge bg-danger">Información del Curso</span></h2>-->
                    <span class="badge text-bg-danger">
                        <h6>Descripción</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Descripción de la intención formativa del curso</label>
                        <textarea class="form-control" id="DescripcionTextarea1" name="DescripcionTextarea1" rows="6"><?php echo $objConsulta->descripcion_intension; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Resultados de aprendizaje del programa a los que apunta la asignatura</label>
                        <textarea class="form-control" id="ResultadosTextarea1" name="ResultadosTextarea1" rows="6"><?php echo $objConsulta->resultados_aprendizaje; ?></textarea>
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
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Estrategia Pedagógica y Didactica</label>
                        <textarea class="form-control" id="EstrategiaTextarea1" name="EstrategiaTextarea1" rows="8"><?php echo $objConsulta->estrategia_pyd; ?></textarea>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Recursos</label>
                        <textarea class="form-control" id="RecursosTextarea1" name="RecursosTextarea1" rows="8"><?php echo $objConsulta->recursos; ?></textarea>
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
                                <th class="th-sm ancho-columna text-center">Porcentaje de actividades formativas (talleres, quices, actividades de seguimiento: trabajos en clases y trabajo independiente) trabajo final</th>
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
                        <input type="text" class="form-control form-control sm" id="Unidad1HP" name="Unidad1HP" value="<?php echo $objConsulta->u1_hp; ?>">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad1HI" name="Unidad1HI" value="<?php echo $objConsulta->u1_hi; ?>">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad1CS" name="Unidad1CS" value="<?php echo $objConsulta->u1_cortesemanas; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U1ResultadosTextarea1" name="U1ResultadosTextarea1" rows="30"><?php echo $objConsulta->u1_resultados; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U1ContenidosTextarea1" name="U1ContenidosTextarea1" rows="30"><?php echo $objConsulta->u1_contenidos; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U1ActividadesTextarea1" name="U1ActividadesTextarea1" rows="30"><?php echo $objConsulta->u1_actividades; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U1SistemaTextarea1" name="U1SistemaTextarea1" rows="30"><?php echo $objConsulta->u1_evaluacion; ?></textarea>
                    </div>
                    <div class="col-md-12 mt-2">
                    </div>
                </div>
            </div>
        </div>

        <div class=" tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab" tabindex="0">
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
                        <input type="text" class="form-control form-control sm" id="Unidad2HP" name="Unidad2HP" value="<?php echo $objConsulta->u2_hp; ?>">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad2HI" name="Unidad2HI" value="<?php echo $objConsulta->u2_hi; ?>">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad2CS" name="Unidad2CS" value="<?php echo $objConsulta->u2_cortesemanas; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U2ResultadosTextarea1" name="U2ResultadosTextarea1" rows="30"><?php echo $objConsulta->u2_resultados; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U2ContenidosTextarea1" name="U2ContenidosTextarea1" rows="30"><?php echo $objConsulta->u2_contenidos; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U2ActividadesTextarea1" name="U2ActividadesTextarea1" rows="30"><?php echo $objConsulta->u2_actividades; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U2SistemaTextarea1" name="U2SistemaTextarea1" rows="30"><?php echo $objConsulta->u2_evaluacion; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                    </div>
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
                        <input type="text" class="form-control form-control sm" id="Unidad3HP" name="Unidad3HP" value="<?php echo $objConsulta->u3_hp; ?>">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Horas Independientes:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad3HI" name="Unidad3HI" value="<?php echo $objConsulta->u3_hi; ?>">
                    </div>
                    <div class=" col-md-3 mt-2">
                        <label for="formGroup" class="form-label">Corte/Semanas:</label>
                        <input type="text" class="form-control form-control sm" id="Unidad3CS" name="Unidad3CS" value="<?php echo $objConsulta->u3_cortesemanas; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">RESULTADOS APRENDIZAJE</label>
                        <textarea class="form-control" id="U3ResultadosTextarea1" name="U3ResultadosTextarea1" rows="30"><?php echo $objConsulta->u3_resultados; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">CONTENIDOS</label>
                        <textarea class="form-control" id="U3ContenidosTextarea1" name="U3ContenidosTextarea1" rows="30"><?php echo $objConsulta->u3_contenidos; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">ACTIVIDADES FORMATIVAS</label>
                        <textarea class="form-control" id="U3ActividadesTextarea1" name="U3ActividadesTextarea1" rows="30"><?php echo $objConsulta->u3_actividades; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="formGroup" class="form-label">SISTEMA DE EVALUACION</label>
                        <textarea class="form-control" id="U3SistemaTextarea1" name="U3SistemaTextarea1" rows="30"><?php echo $objConsulta->u3_evaluacion; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2">
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-6" role="tabpanel" aria-labelledby="pills-6-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <span class="badge text-bg-danger">
                        <h6>Proyecto Integrador</h6>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control form-control sm" id="NombreProy" name="NombreProy" value="<?php echo $objConsulta->nombre_proyecto; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Asignaturas implicadas en el proyecto</label>
                        <textarea class="form-control" id="AsignaturaProy" name="AsignaturaProy" rows="2"><?php echo $objConsulta->proy_asignaturas; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Temáticas de investigación a desarrollar en el proyecto integrador</label>
                        <textarea class="form-control" id="TematicasProy" name="TematicasProy" rows="2"><?php echo $objConsulta->proy_tematicas; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="formGroup" class="form-label">Acciones por realizar en el proyecto integrador</label>
                        <textarea class="form-control" id="AccionesProy" name="AccionesProy" rows="2"><?php echo $objConsulta->proy_acciones; ?></textarea>
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
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Bibliografía existente en la biblioteca institucional</label>
                        <textarea class="form-control" id="ReferBiblio" name="ReferBiblio" rows="3"><?php echo $objConsulta->ref_biblio; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Otra bibliografía</label>
                        <textarea class="form-control" id="ReferOtra" name="ReferOtra" rows="3"><?php echo $objConsulta->ref_otra; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Referencias en inglés</label>
                        <textarea class="form-control" id="ReferIngles" name="ReferIngles" rows="3"><?php echo $objConsulta->ref_ingles ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="formGroup" class="form-label">Webgrafía y bases de datos</label>
                        <textarea class="form-control" id="ReferWebgrafia" name="ReferWebgrafia" rows="3"><?php echo $objConsulta->ref_webgrafia; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-2"></div>
            </div>
            <div class="text-center">
                <input class="btn btn-danger" id="BtnGuardar" type="submit">Guardar</input>
            </div>
        </div>
    </div>
</form>

