<?php

date_default_timezone_set("America/Bogota");
session_start();
include('conextemp.php');

//temporal

$query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
$resultado_temp = pg_query($conexion2, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$codigoConsulta = $obj_temp->valor2;

$tablam3 = $_SESSION['tablam3'];

//select fechas
$query_tm3fechas = "SELECT * FROM $tablam3 WHERE id='$codigoConsulta'";
$resultado_tm3fechas = pg_query($conexion2, $query_tm3fechas);
$objfechas = pg_fetch_object($resultado_tm3fechas);


// select de tabla estrategia metodologica 1
$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest1p = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 1

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet1p = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 2

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest2p = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 2

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet2p = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 3

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest3p = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 3

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet3p = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 4

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest4p = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 4

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet4p = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 5

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest5p = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 5

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet5p = pg_query($conexion2, $query_metodo);

$query_periodo = "SELECT * FROM sistema.periodos WHERE estado='ACTIVO' ORDER BY codigo_periodo ASC ";
$resultado_qper = pg_query($conexion2, $query_periodo);

// select de tabla estrategia metodologica 1

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest1 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 1

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet1 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 2

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest2 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 2

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet2 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 3

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest3 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 3

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet3 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 4

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest4 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 4

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet4 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 5

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest5 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 5

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet5 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 6

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest6 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 6

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet6 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 7

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest7 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 7

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet7 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 8

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest8 = pg_query($conexion2, $query_estrategia);


// select de tabla metodologia evaluacion 8

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet8 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 9

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest9 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 9

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet9 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 10

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest10 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 10

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet10 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 11

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest11 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 11

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet11 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 12

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest12 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 12

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet12 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 13

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest13 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 13

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet13 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 14

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest14 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 14

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet14 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 15

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest15 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 15

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet15 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 16

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest16 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 16

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet16 = pg_query($conexion2, $query_metodo);

$query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
$resultado_temp = pg_query($conexion2, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$value = strval($obj_temp->valor1);

?>

<?php

if ($value <> "26" && $value <> "30" && $value <> "31" && $value <> "32") { ?>

    <div class="container">
        <div class="row">
            <span class="badge text-bg-danger">
                <h5>Registro de Actividades</h5>
            </span>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2">
                <h6><span class="badge bg-danger">Semana</span></h6>
            </div>
            <div class="col-md-4 mt-2">
                <h6><span class="badge bg-danger">Tipo Actividad</span></h6>
            </div>
        </div>
        <!-- establecer fecha del dia -->
        <?php $fechahoy = strtotime(date("d-m-Y")); ?>
        <!-- semana 1 -->
        <?php
        $fechai1 = strtotime($objfechas->s1_rangoi);
        $fechaf1 = date("d-m-Y", strtotime($objfechas->s1_rangof . "+ 1 days"));
        $fechaf1 = strtotime($fechaf1);

        if ($fechahoy >= $fechai1 &&  $fechahoy <= $fechaf1) { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem1" name="titulosem1" value="Semana 1" readonly>

                        <label class="col-md-1" for="rangoinicio1">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio1" name="rangoinicio1" value="<?php echo $objfechas->s1_rangoi; ?>" readonly>

                        <label for="rangofinal1" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal1" name="rangofinal1" value="<?php echo $objfechas->s1_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad1" name="TipoActividad1" onchange="showopt1s1();">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s1divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem1" name="DescripcionActSem1" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s1divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad1" name="TipoNovedad1" onchange="showopt2s1();">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s1divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem1" name="justificasem1" placeholder="Justiicación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s1divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov1" name="fechanov1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s1divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio1" name="fecharepinicio1">
                    </div>
                    <div class="col-md-6 mt-2" id="s1divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Final</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal1" name="fecharepfinal1">
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- Semana2 -->
        <?php
        $fechai2 = strtotime($objfechas->s2_rangoi);
        $fechaf2 = date("d-m-Y", strtotime($objfechas->s2_rangof . "+ 1 days"));
        $fechaf2 = strtotime($fechaf2);

        if ($fechahoy >= $fechai2 &&  $fechahoy <= $fechaf2) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem2" name="titulosem2" value="Semana 2" readonly>

                        <label class="col-md-1" for="rangoinicio2">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio2" name="rangoinicio2" value="<?php echo $objfechas->s2_rangoi; ?>" readonly>

                        <label for="rangofinal2" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal2" name="rangofinal2" value="<?php echo $objfechas->s2_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad2" name="TipoActividad2" onchange="showopt1s2()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s2divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem2" name="DescripcionActSem2" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s2divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad2" name="TipoNovedad2" onchange="showopt2s2()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s2divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem1" name="justificasem1" placeholder="Justiicación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s2divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov2" name="fechanov2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s2divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio2" name="fecharepinicio2">
                    </div>
                    <div class="col-md-6 mt-2" id="s2divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal2" name="fecharepfinal2">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana3 -->
        <?php
        $fechai3 = strtotime($objfechas->s3_rangoi);
        $fechaf3 = date("d-m-Y", strtotime($objfechas->s3_rangof . "+ 1 days"));
        $fechaf3 = strtotime($fechaf3);

        if ($fechahoy >= $fechai3 &&  $fechahoy <= $fechaf3) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem3" name="titulosem3" value="Semana 3" readonly>

                        <label class="col-md-1" for="rangoinicio3">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio3" name="rangoinicio3" value="<?php echo $objfechas->s3_rangoi; ?>" readonly>

                        <label for="rangofinal3" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal3" name="rangofinal3" value="<?php echo $objfechas->s3_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad3" name="TipoActividad3" onchange="showopt1s3()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s3divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem3" name="DescripcionActSem3" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s3divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad3" name="TipoNovedad3" onchange="showopt2s3()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s3divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem3" name="justificasem3" placeholder="Justiicación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s3divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov3" name="fechanov3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s3divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio3" name="fecharepinicio3">
                    </div>
                    <div class="col-md-6 mt-2" id="s3divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal3" name="fecharepfinal3">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana4 -->
        <?php
        $fechai4 = strtotime($objfechas->s4_rangoi);
        $fechaf4 = date("d-m-Y", strtotime($objfechas->s4_rangof . "+ 1 days"));
        $fechaf4 = strtotime($fechaf4);

        if ($fechahoy >= $fechai4 &&  $fechahoy <= $fechaf4) { ?>
            <div class="row border border-danger rounded">
                <div class="col-md-8 mt-2">
                    <input type="text" class="inputClass col-md-2" id="titulosem4" name="titulosem4" value="Semana 4" readonly>

                    <label class="col-md-1" for="rangoinicio4">Del:</label>
                    <input type="text" class="col-md-2" id="rangoinicio4" name="rangoinicio4" value="<?php echo $objfechas->s4_rangoi; ?>" readonly>

                    <label for="rangofinal4" class="col-md-1">Al:</label>
                    <input type="text" class="col-md-2" id="rangofinal4" name="rangofinal4" value="<?php echo $objfechas->s4_rangof; ?>" readonly>
                </div>
                <div class="col-md-4 mt-2">
                    <select class="form-select form-select-sm" id="TipoActividad4" name="TipoActividad4" onchange="showopt1s4()">
                        <option value="" selected>Escoger Opción</option>
                        <option value="Regular">Regular</option>
                        <option value="Novedad">Novedad</option>
                    </select>
                </div>

                <div class="row" id="s4divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem4" name="DescripcionActSem4" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s4divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad4" name="TipoNovedad4" onchange="showopt2s4()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s4divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem4" name="justificasem4" placeholder="Justiicación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s4divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov4" name="fechanov4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s4divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio4" name="fecharepinicio4">
                    </div>
                    <div class="col-md-6 mt-2" id="s4divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal4" name="fecharepfinal4">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana5 -->
        <?php
        $fechai5 = strtotime($objfechas->s5_rangoi);
        $fechaf5 = date("d-m-Y", strtotime($objfechas->s5_rangof . "+ 1 days"));
        $fechaf5 = strtotime($fechaf5);

        if ($fechahoy >= $fechai5 &&  $fechahoy <= $fechaf5) { ?>
            <div class="row border border-danger rounded mt-1">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem5" name="titulosem5" value="Semana 5" readonly>

                        <label class="col-md-1" for="rangoinicio5">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio5" name="rangoinicio5" value="<?php echo $objfechas->s5_rangoi; ?>" readonly>

                        <label for="rangofinal5" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal5" name="rangofinal5" value="<?php echo $objfechas->s5_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad5" name="TipoActividad5" onchange="showopt1s5()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s5divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem5" name="DescripcionActSem5" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s5divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad5" name="TipoNovedad5" onchange="showopt2s5()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s5divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem5" name="justificasem5" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s5divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov5" name="fechanov5">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s5divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio5" name="fecharepinicio5">
                    </div>
                    <div class="col-md-6 mt-2" id="s5divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal5" name="fecharepfinal5">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana6 -->
        <?php
        $fechai6 = strtotime($objfechas->s6_rangoi);
        $fechaf6 = date("d-m-Y", strtotime($objfechas->s6_rangof . "+ 1 days"));
        $fechaf6 = strtotime($fechaf6);

        if ($fechahoy >= $fechai6 &&  $fechahoy <= $fechaf6) { ?>
            <div class="row border border-danger rounded mt-1">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem6" name="titulosem6" value="Semana 6" readonly>

                        <label class="col-md-1" for="rangoinicio6">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio6" name="rangoinicio6" value="<?php echo $objfechas->s6_rangoi; ?>" readonly>

                        <label for="rangofinal6" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal6" name="rangofinal6" value="<?php echo $objfechas->s6_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad6" name="TipoActividad6" onchange="showopt1s6()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s6divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem6" name="DescripcionActSem6" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s6divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad6" name="TipoNovedad6" onchange="showopt2s6()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s6divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem6" name="justificasem6" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s6divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov6" name="fechanov6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s6divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio6" name="fecharepinicio6">
                    </div>
                    <div class="col-md-6 mt-2" id="s6divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal6" name="fecharepfinal6">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana7 -->
        <?php
        $fechai7 = strtotime($objfechas->s7_rangoi);
        $fechaf7 = date("d-m-Y", strtotime($objfechas->s7_rangof . "+ 1 days"));
        $fechaf7 = strtotime($fechaf7);

        if ($fechahoy >= $fechai7 &&  $fechahoy <= $fechaf7) { ?>
            <div class="row border border-danger rounded mt-1">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem7" name="titulosem7" value="Semana 7" readonly>

                        <label class="col-md-1" for="rangoinicio7">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio7" name="rangoinicio7" value="<?php echo $objfechas->s7_rangoi; ?>" readonly>

                        <label for="rangofinal7" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal7" name="rangofinal7" value="<?php echo $objfechas->s7_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad7" name="TipoActividad7" onchange="showopt1s7()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s7divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem7" name="DescripcionActSem7" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s7divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad7" name="TipoNovedad7" onchange="showopt2s7()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s7divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem7" name="justificasem7" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s7divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov7" name="fechanov7">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s7divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio7" name="fecharepinicio7">
                    </div>
                    <div class="col-md-6 mt-2" id="s7divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal7" name="fecharepfinal7">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana8 -->
        <?php
        $fechai8 = strtotime($objfechas->s8_rangoi);
        $fechaf8 = date("d-m-Y", strtotime($objfechas->s8_rangof . "+ 1 days"));
        $fechaf8 = strtotime($fechaf8);

        if ($fechahoy >= $fechai8 &&  $fechahoy <= $fechaf8) { ?>
            <div class="row border border-danger rounded mt-1">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem8" name="titulosem8" value="Semana 8" readonly>

                        <label class="col-md-1" for="rangoinicio8">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio8" name="rangoinicio8" value="<?php echo $objfechas->s8_rangoi; ?>" readonly>

                        <label for="rangofinal8" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal8" name="rangofinal8" value="<?php echo $objfechas->s8_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad8" name="TipoActividad8" onchange="showopt1s8()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s8divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem8" name="DescripcionActSem8" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s8divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad8" name="TipoNovedad8" onchange="showopt2s8()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s8divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem8" name="justificasem8" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s8divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov8" name="fechanov8">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s8divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio8" name="fecharepinicio8">
                    </div>
                    <div class="col-md-6 mt-2" id="s8divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal8" name="fecharepfinal8">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana9 -->
        <?php
        $fechai9 = strtotime($objfechas->s9_rangoi);
        $fechaf9 = date("d-m-Y", strtotime($objfechas->s9_rangof . "+ 1 days"));
        $fechaf9 = strtotime($fechaf9);

        if ($fechahoy >= $fechai9 &&  $fechahoy <= $fechaf9) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem9" name="titulosem9" value="Semana 9" readonly>

                        <label class="col-md-1" for="rangoinicio9">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio9" name="rangoinicio9" value="<?php echo $objfechas->s9_rangoi; ?>" readonly>

                        <label for="rangofinal9" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal9" name="rangofinal9" value="<?php echo $objfechas->s9_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad9" name="TipoActividad9" onchange="showopt1s9()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s9divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem9" name="DescripcionActSem9" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s9divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad9" name="TipoNovedad9" onchange="showopt2s9()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s9divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem9" name="justificasem9" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s9divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov9" name="fechanov9">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s9divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio9" name="fecharepinicio9">
                    </div>
                    <div class="col-md-6 mt-2" id="s9divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal9" name="fecharepfinal9">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana10 -->
        <?php
        $fechai10 = strtotime($objfechas->s10_rangoi);
        $fechaf10 = date("d-m-Y", strtotime($objfechas->s10_rangof . "+ 1 days"));
        $fechaf10 = strtotime($fechaf10);

        if ($fechahoy >= $fechai10 &&  $fechahoy <= $fechaf10) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem10" name="titulosem10" value="Semana 10" readonly>

                        <label class="col-md-1" for="rangoinicio10">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio10" name="rangoinicio10" value="<?php echo $objfechas->s10_rangoi; ?>" readonly>

                        <label for="rangofinal10" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal10" name="rangofinal10" value="<?php echo $objfechas->s10_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad10" name="TipoActividad10" onchange="showopt1s10()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s10divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem10" name="DescripcionActSem10" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s10divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad10" name="TipoNovedad10" onchange="showopt2s10()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s10divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem10" name="justificasem10" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s10divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov10" name="fechanov10">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s10divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio10" name="fecharepinicio10">
                    </div>
                    <div class="col-md-6 mt-2" id="s10divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal10" name="fecharepfinal10">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana11 -->
        <?php
        $fechai11 = strtotime($objfechas->s11_rangoi);
        $fechaf11 = date("d-m-Y", strtotime($objfechas->s11_rangof . "+ 1 days"));
        $fechaf11 = strtotime($fechaf11);

        if ($fechahoy >= $fechai11 &&  $fechahoy <= $fechaf11) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem11" name="titulosem11" value="Semana 11" readonly>

                        <label class="col-md-1" for="rangoinicio11">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio11" name="rangoinicio11" value="<?php echo $objfechas->s11_rangoi; ?>" readonly>

                        <label for="rangofinal10" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal11" name="rangofinal11" value="<?php echo $objfechas->s11_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad11" name="TipoActividad11" onchange="showopt1s11()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s11divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem11" name="DescripcionActSem11" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s11divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad11" name="TipoNovedad11" onchange="showopt2s11()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s11divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem11" name="justificasem11" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s11divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov11" name="fechanov11">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s11divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio11" name="fecharepinicio11">
                    </div>
                    <div class="col-md-6 mt-2" id="s11divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal11" name="fecharepfinal11">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana12 -->
        <?php
        $fechai12 = strtotime($objfechas->s12_rangoi);
        $fechaf12 = date("d-m-Y", strtotime($objfechas->s12_rangof . "+ 1 days"));
        $fechaf12 = strtotime($fechaf12);

        if ($fechahoy >= $fechai12 &&  $fechahoy <= $fechaf12) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem12" name="titulosem12" value="Semana 12" readonly>

                        <label class="col-md-1" for="rangoinicio12">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio12" name="rangoinicio12" value="<?php echo $objfechas->s12_rangoi; ?>" readonly>

                        <label for="rangofinal12" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal12" name="rangofinal12" value="<?php echo $objfechas->s12_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad12" name="TipoActividad12" onchange="showopt1s12()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s12divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem12" name="DescripcionActSem12" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s12divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad12" name="TipoNovedad12" onchange="showopt2s12()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s12divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem12" name="justificasem12" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s12divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov12" name="fechanov12">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s12divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio12" name="fecharepinicio12">
                    </div>
                    <div class="col-md-6 mt-2" id="s12divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal12" name="fecharepfinal12">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana13 -->
        <?php
        $fechai13 = strtotime($objfechas->s13_rangoi);
        $fechaf13 = date("d-m-Y", strtotime($objfechas->s13_rangof . "+ 1 days"));
        $fechaf13 = strtotime($fechaf13);

        if ($fechahoy >= $fechai13 &&  $fechahoy <= $fechaf13) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem13" name="titulosem13" value="Semana 13" readonly>

                        <label class="col-md-1" for="rangoinicio13">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio13" name="rangoinicio13" value="<?php echo $objfechas->s13_rangoi; ?>" readonly>

                        <label for="rangofinal13" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal13" name="rangofinal13" value="<?php echo $objfechas->s13_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad13" name="TipoActividad13" onchange="showopt1s13()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s13divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem13" name="DescripcionActSem13" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s13divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad13" name="TipoNovedad13" onchange="showopt2s13()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s13divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem13" name="justificasem13" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s13divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov13" name="fechanov13">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s13divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio13" name="fecharepinicio13">
                    </div>
                    <div class="col-md-6 mt-2" id="s13divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal13" name="fecharepfinal13">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana14 -->
        <?php
        $fechai14 = strtotime($objfechas->s14_rangoi);
        $fechaf14 = date("d-m-Y", strtotime($objfechas->s14_rangof . "+ 1 days"));
        $fechaf14 = strtotime($fechaf14);

        if ($fechahoy >= $fechai14 &&  $fechahoy <= $fechaf14) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem14" name="titulosem14" value="Semana 14" readonly>

                        <label class="col-md-1" for="rangoinicio14">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio14" name="rangoinicio14" value="<?php echo $objfechas->s14_rangoi; ?>" readonly>

                        <label for="rangofinal14" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal14" name="rangofinal14" value="<?php echo $objfechas->s14_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad14" name="TipoActividad14" onchange="showopt1s14()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s14divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem14" name="DescripcionActSem14" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s14divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad14" name="TipoNovedad14" onchange="showopt2s14()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s14divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem14" name="justificasem14" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s14divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov14" name="fechanov14">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s14divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio14" name="fecharepinicio14">
                    </div>
                    <div class="col-md-6 mt-2" id="s14divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal14" name="fecharepfinal14">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana15 -->
        <?php
        $fechai15 = strtotime($objfechas->s15_rangoi);
        $fechaf15 = date("d-m-Y", strtotime($objfechas->s15_rangof . "+ 1 days"));
        $fechaf15 = strtotime($fechaf15);

        if ($fechahoy >= $fechai15 &&  $fechahoy <= $fechaf15) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem15" name="titulosem15" value="Semana 15" readonly>

                        <label class="col-md-1" for="rangoinicio15">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio15" name="rangoinicio15" value="<?php echo $objfechas->s15_rangoi; ?>" readonly>

                        <label for="rangofinal15" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal15" name="rangofinal15" value="<?php echo $objfechas->s15_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad15" name="TipoActividad15" onchange="showopt1s15()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s15divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem15" name="DescripcionActSem15" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s15divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad15" name="TipoNovedad15" onchange="showopt2s15()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s15divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem15" name="justificasem15" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s15divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov15" name="fechanov15">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s15divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio15" name="fecharepinicio15">
                    </div>
                    <div class="col-md-6 mt-2" id="s15divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal15" name="fecharepfinal15">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana16 -->
        <?php
        $fechai16 = strtotime($objfechas->s16_rangoi);
        $fechaf16 = date("d-m-Y", strtotime($objfechas->s16_rangof . "+ 1 days"));
        $fechaf16 = strtotime($fechaf16);

        if ($fechahoy >= $fechai16 &&  $fechahoy <= $fechaf16) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem16" name="titulosem16" value="Semana 16" readonly>

                        <label class="col-md-1" for="rangoinicio16">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio16" name="rangoinicio16" value="<?php echo $objfechas->s16_rangoi; ?>" readonly>

                        <label for="rangofinal16" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal16" name="rangofinal16" value="<?php echo $objfechas->s16_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <select class="form-select form-select-sm" id="TipoActividad16" name="TipoActividad16" onchange="showopt1s16()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Regular">Regular</option>
                            <option value="Novedad">Novedad</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="s16divopt1" style="display: none">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem16" name="DescripcionActSem16" placeholder="Descripcion" rows="6"></textarea>
                    </div>
                </div>
                <div class="row" id="s16divopt2" style="display: none">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad16" name="TipoNovedad16" onchange="showopt2s16()">
                            <option value="" selected>Escoger Opción</option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s16divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem16" name="justificasem16" placeholder="Justificación" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s16divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov16" name="fechanov16">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s16divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepinicio16" name="fecharepinicio16">
                    </div>
                    <div class="col-md-6 mt-2" id="s16divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Fecha Reprogramacion Inicio</span></h6>
                        <input type="date" class="form-control form-control sm" id="fecharepfinal16" name="fecharepfinal16">
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <div class="container">
            <div class="row">
                <span class="badge text-bg-danger">
                    <h5>Registro de Actividades</h5>
                </span>
            </div>
            <div class="row">
                <div class="col-md-8 mt-2">
                    <h6><span class="badge bg-danger">Semana</span></h6>
                </div>
                <div class="col-md-4 mt-2">
                    <h6><span class="badge bg-danger">Tipo Actividad</span></h6>
                </div>
            </div>
            <!-- establecer fecha del dia -->
            <?php $fechahoy = strtotime(date("d-m-Y")); ?>

            <!-- semana 1 p -->
            <?php
            $fechai1p = strtotime($objfechas->s1_rangoi_p);
            $fechaf1p = date("d-m-Y", strtotime($objfechas->s1_rangof_p . "+ 1 days"));
            $fechaf1p = strtotime($fechaf1p);

            if ($fechahoy >= $fechai1p &&  $fechahoy <= $fechaf1p) { ?>
                <div class="row border border-danger rounded mt-1">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <input type="text" class="inputClass col-md-2" id="titulosem1p" name="titulosem1p" value="Semana 1" readonly>

                            <label class="col-md-1" for="rangoinicio1p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio1p" name="rangoinicio1p" value="<?php echo $objfechas->s1_rangoi_p; ?>" readonly>

                            <label for="rangofinal1p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal1p" name="rangofinal1p" value="<?php echo $objfechas->s1_rangof_p; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select class="form-select form-select-sm" id="TipoActividad1p" name="TipoActividad1p" onchange="showopt1s1p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Regular">Regular</option>
                                <option value="Novedad">Novedad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="s1pdivopt1" style="display: none">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem1p" name="DescripcionActSem1p" placeholder="Descripcion" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="row" id="s1pdivopt2" style="display: none">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad1p" name="TipoNovedad1p" onchange="showopt2s1p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s1pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem1p" name="justificasem1p" placeholder="Justiicación" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mt-2" id="s1pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov1p" name="fechanov1p">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s1pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepinicio1p" name="fecharepinicio1p">
                        </div>
                        <div class="col-md-6 mt-2" id="s1pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Final</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepfinal1p" name="fecharepfinal1p">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana2 -->

            <?php
            $fechai2p = strtotime($objfechas->s2_rangoi_p);
            $fechaf2p = date("d-m-Y", strtotime($objfechas->s2_rangof_p . "+ 1 days"));
            $fechaf2p = strtotime($fechaf2p);


            if ($fechahoy >= $fechai2p &&  $fechahoy <= $fechaf2p) { ?>
                <div class="row border border-danger rounded mt-1">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <input type="text" class="inputClass col-md-2" id="titulosem2p" name="titulosem2p" value="Semana 2" readonly>

                            <label class="col-md-1" for="rangoinicio2p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio2p" name="rangoinicio2p" value="<?php echo $objfechas->s2_rangoi_p; ?>" readonly>

                            <label for="rangofinal1p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal2p" name="rangofinal2p" value="<?php echo $objfechas->s2_rangof_p; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select class="form-select form-select-sm" id="TipoActividad2p" name="TipoActividad2p" onchange="showopt1s2p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Regular">Regular</option>
                                <option value="Novedad">Novedad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="s2pdivopt1" style="display: none">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem2p" name="DescripcionActSem2p" placeholder="Descripcion" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="row" id="s2pdivopt2" style="display: none">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad2p" name="TipoNovedad2p" onchange="showopt2s2p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s2pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem2p" name="justificasem2p" placeholder="Justiicación" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mt-2" id="s2pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov2p" name="fechanov2p">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s2pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepinicio2p" name="fecharepinicio2p">
                        </div>
                        <div class="col-md-6 mt-2" id="s2pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Final</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepfinal2p" name="fecharepfinal2p">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana3 -->

            <?php
            $fechai3p = strtotime($objfechas->s3_rangoi_p);
            $fechaf3p = date("d-m-Y", strtotime($objfechas->s3_rangof_p . "+ 1 days"));
            $fechaf3p = strtotime($fechaf3p);


            if ($fechahoy >= $fechai3p &&  $fechahoy <= $fechaf3p) { ?>
                <div class="row border border-danger rounded mt-1">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <input type="text" class="inputClass col-md-2" id="titulosem3p" name="titulosem3p" value="Semana 3" readonly>

                            <label class="col-md-1" for="rangoinicio2p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio3p" name="rangoinicio3p" value="<?php echo $objfechas->s3_rangoi_p; ?>" readonly>

                            <label for="rangofinal1p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal3p" name="rangofinal3p" value="<?php echo $objfechas->s3_rangof_p; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select class="form-select form-select-sm" id="TipoActividad3p" name="TipoActividad3p" onchange="showopt1s3p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Regular">Regular</option>
                                <option value="Novedad">Novedad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="s3pdivopt1" style="display: none">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem3p" name="DescripcionActSem3p" placeholder="Descripcion" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="row" id="s3pdivopt2" style="display: none">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad3p" name="TipoNovedad3p" onchange="showopt2s3p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s3pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem3p" name="justificasem3p" placeholder="Justiicación" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mt-2" id="s3pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov3p" name="fechanov3p">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s3pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepinicio3p" name="fecharepinicio3p">
                        </div>
                        <div class="col-md-6 mt-2" id="s3pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Final</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepfinal3p" name="fecharepfinal3p">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana4 -->
            <?php
            $fechai4p = strtotime($objfechas->s4_rangoi_p);
            $fechaf4p = date("d-m-Y", strtotime($objfechas->s4_rangof_p . "+ 1 days"));
            $fechaf4p = strtotime($fechaf4p);


            if ($fechahoy >= $fechai4p &&  $fechahoy <= $fechaf4p) { ?>
                <div class="row border border-danger rounded mt-1">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <input type="text" class="inputClass col-md-2" id="titulosem4p" name="titulosem4p" value="Semana 4" readonly>

                            <label class="col-md-1" for="rangoinicio4p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio4p" name="rangoinicio4p" value="<?php echo $objfechas->s4_rangoi_p; ?>" readonly>

                            <label for="rangofinal1p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal4p" name="rangofinal4p" value="<?php echo $objfechas->s4_rangof_p; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select class="form-select form-select-sm" id="TipoActividad4p" name="TipoActividad4p" onchange="showopt1s4p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Regular">Regular</option>
                                <option value="Novedad">Novedad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="s4pdivopt1" style="display: none">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem4p" name="DescripcionActSem4p" placeholder="Descripcion" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="row" id="s4pdivopt2" style="display: none">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad4p" name="TipoNovedad4p" onchange="showopt2s4p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s4pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem4p" name="justificasem4p" placeholder="Justiicación" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mt-2" id="s4pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov4p" name="fechanov4p">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s4pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepinicio4p" name="fecharepinicio4p">
                        </div>
                        <div class="col-md-6 mt-2" id="s4pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Final</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepfinal4p" name="fecharepfinal4p">
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Semana5 -->
            <?php
            $fechai5p = strtotime($objfechas->s5_rangoi_p);
            $fechaf5p = date("d-m-Y", strtotime($objfechas->s5_rangof_p . "+ 1 days"));
            $fechaf5p = strtotime($fechaf5p);


            if ($fechahoy >= $fechai5p &&  $fechahoy <= $fechaf5p) { ?>
                <div class="row border border-danger rounded mt-1">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <input type="text" class="inputClass col-md-2" id="titulosem5p" name="titulosem5p" value="Semana 5" readonly>

                            <label class="col-md-1" for="rangoinicio5p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio5p" name="rangoinicio5p" value="<?php echo $objfechas->s5_rangoi_p; ?>" readonly>

                            <label for="rangofinal5p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal5p" name="rangofinal5p" value="<?php echo $objfechas->s5_rangof_p; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select class="form-select form-select-sm" id="TipoActividad5p" name="TipoActividad5p" onchange="showopt1s5p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Regular">Regular</option>
                                <option value="Novedad">Novedad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="s5pdivopt1" style="display: none">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem5p" name="DescripcionActSem5p" placeholder="Descripcion" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="row" id="s5pdivopt2" style="display: none">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad5p" name="TipoNovedad5p" onchange="showopt2s5p();">
                                <option value="" selected>Escoger Opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s5pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem5p" name="justificasem5p" placeholder="Justificación" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mt-2" id="s5pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov5p" name="fechanov5p">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s5pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Inicio</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepinicio5p" name="fecharepinicio5p">
                        </div>
                        <div class="col-md-6 mt-2" id="s5pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramacion Final</span></h6>
                            <input type="date" class="form-control form-control sm" id="fecharepfinal5p" name="fecharepfinal5p">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!--Hastaaqui -->
        <?php
    } ?>