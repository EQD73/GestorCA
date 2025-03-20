<?php

date_default_timezone_set("America/Bogota");
session_start();
include('conextemp.php');

//temporal

/* $query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
$resultado_temp = pg_query($conexion2, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$codigoConsulta = $obj_temp->valor2; */


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
$codigoConsulta = $id;

$tablam3 = $_SESSION['tablam3'];

//select fechas
$query_tm3fechas = "SELECT * FROM $tablam3 WHERE id='$codigoConsulta'";
$resultado_tm3fechas = pg_query($conexion2, $query_tm3fechas);
$objfechas = pg_fetch_object($resultado_tm3fechas);


$query_periodo = "SELECT * FROM sistema.periodos WHERE estado='ACTIVO' ORDER BY codigo_periodo ASC ";
$resultado_qper = pg_query($conexion2, $query_periodo);

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
        <!-- Semana1 -->
        <?php
        $fechai1 = strtotime($objfechas->s1_rangoi);
        $fechaf1 = date("d-m-Y", strtotime($objfechas->s1_rangof . "+ 1 days"));
        $fechaf1 = strtotime($fechaf1);

        if ($fechahoy > $fechaf1 && ($objfechas->s1_tipoactividad == " " || $objfechas->s1_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem1" name="titulosem1" value="Semana 1" readonly>

                        <label class="col-md-1" for="rangoinicio1">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio1" name="rangoinicio1" value="<?php echo $objfechas->s1_rangoi; ?>" readonly>

                        <label for="rangofinal1" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal1" name="rangofinal1" value="<?php echo $objfechas->s1_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad1" name="TipoActividad1" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s1divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem1" name="DescripcionActSem1" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s1divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad1" name="TipoNovedad1" onchange="showopt2s1()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s1divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem1" name="justificasem1" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s1divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov1" name="fechanov1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s1divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem1" name="justificarsem1" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s1divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s1fecharep1" name="s1fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s1divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s1fecharep2" name="s1fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
      <!--Semana2-->
        <?php
        $fechai2 = strtotime($objfechas->s2_rangoi);
        $fechaf2 = date("d-m-Y", strtotime($objfechas->s2_rangof . "+ 1 days"));
        $fechaf2 = strtotime($fechaf2);

        if ($fechahoy > $fechaf2 && ($objfechas->s2_tipoactividad == " " || $objfechas->s2_tipoactividad == null)) { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad2" name="TipoActividad2" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s2divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem2" name="DescripcionActSem2" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s2divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad2" name="TipoNovedad2" onchange="showopt2s2()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s2divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem2" name="justificasem2" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s2divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov2" name="fechanov2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s2divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem2" name="justificarsem2" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s2divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s2fecharep1" name="s2fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s2divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s2fecharep2" name="s2fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana3 -->
        <?php
        $fechai3 = strtotime($objfechas->s3_rangoi);
        $fechaf3 = date("d-m-Y", strtotime($objfechas->s3_rangof . "+ 1 days"));
        $fechaf3 = strtotime($fechaf3);

        if ($fechahoy > $fechaf3 && ($objfechas->s3_tipoactividad == " " || $objfechas->s3_tipoactividad == null)) { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad3" name="TipoActividad3" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s3divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem3" name="DescripcionActSem3" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s3divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad3" name="TipoNovedad3" onchange="showopt2s3()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s3divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem3" name="justificasem3" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s3divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov3" name="fechanov3">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s3divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem3" name="justificarsem3" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s3divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3fecharep1" name="s3fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s3divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3fecharep2" name="s3fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana4 -->
        <?php
        $fechai4 = strtotime($objfechas->s4_rangoi);
        $fechaf4 = date("d-m-Y", strtotime($objfechas->s4_rangof . "+ 1 days"));
        $fechaf4 = strtotime($fechaf4);

        if ($fechahoy > $fechaf4 && ($objfechas->s4_tipoactividad == " " || $objfechas->s4_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem4" name="titulosem4" value="Semana 4" readonly>

                        <label class="col-md-1" for="rangoinicio4">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio4" name="rangoinicio4" value="<?php echo $objfechas->s4_rangoi; ?>" readonly>

                        <label for="rangofinal4" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal4" name="rangofinal4" value="<?php echo $objfechas->s4_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad4" name="TipoActividad4" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s4divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem4" name="DescripcionActSem4" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s4divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad4" name="TipoNovedad4" onchange="showopt2s4()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s4divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem4" name="justificasem4" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s4divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov4" name="fechanov4">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s4divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem4" name="justificarsem4" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s4divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s4fecharep1" name="s4fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s4divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s4fecharep2" name="s4fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana5 -->
        <?php
        $fechai5 = strtotime($objfechas->s5_rangoi);
        $fechaf5 = date("d-m-Y", strtotime($objfechas->s5_rangof . "+ 1 days"));
        $fechaf5 = strtotime($fechaf5);

        if ($fechahoy > $fechaf5 && ($objfechas->s5_tipoactividad == " " || $objfechas->s5_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem5" name="titulosem5" value="Semana 5" readonly>

                        <label class="col-md-1" for="rangoinicio5">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio5" name="rangoinicio5" value="<?php echo $objfechas->s5_rangoi; ?>" readonly>

                        <label for="rangofinal5" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal5" name="rangofinal5" value="<?php echo $objfechas->s5_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad5" name="TipoActividad5" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s5divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem5" name="DescripcionActSem5" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s5divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad5" name="TipoNovedad5" onchange="showopt2s5()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s5divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem5" name="justificasem5" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s5divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov5" name="fechanov5">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s5divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem5" name="justificarsem5" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s5divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s5fecharep1" name="s5fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s5divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s5fecharep2" name="s5fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Semana6 -->
        <?php
        $fechai6 = strtotime($objfechas->s6_rangoi);
        $fechaf6 = date("d-m-Y", strtotime($objfechas->s6_rangof . "+ 1 days"));
        $fechaf6 = strtotime($fechaf6);

        if ($fechahoy > $fechaf6 && ($objfechas->s6_tipoactividad == " " || $objfechas->s6_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem6" name="titulosem6" value="Semana 6" readonly>

                        <label class="col-md-1" for="rangoinicio6">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio6" name="rangoinicio6" value="<?php echo $objfechas->s6_rangoi; ?>" readonly>

                        <label for="rangofinal6" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal6" name="rangofinal6" value="<?php echo $objfechas->s6_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad6" name="TipoActividad6" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s6divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem6" name="DescripcionActSem6" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s6divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad6" name="TipoNovedad6" onchange="showopt2s6()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s6divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem6" name="justificasem6" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s6divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov6" name="fechanov6">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s6divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem6" name="justificarsem6" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s6divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s6fecharep1" name="s6fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s6divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s6fecharep2" name="s6fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana7 -->
        <?php
        $fechai7 = strtotime($objfechas->s7_rangoi);
        $fechaf7 = date("d-m-Y", strtotime($objfechas->s7_rangof . "+ 1 days"));
        $fechaf7 = strtotime($fechaf7);

        if ($fechahoy > $fechaf7 && ($objfechas->s7_tipoactividad == " " || $objfechas->s7_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem7" name="titulosem7" value="Semana 7" readonly>

                        <label class="col-md-1" for="rangoinicio7">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio7" name="rangoinicio7" value="<?php echo $objfechas->s7_rangoi; ?>" readonly>

                        <label for="rangofinal7" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal7" name="rangofinal7" value="<?php echo $objfechas->s7_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad7" name="TipoActividad7" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s7divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem7" name="DescripcionActSem7" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s7divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad7" name="TipoNovedad7" onchange="showopt2s7()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s7divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem7" name="justificasem7" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s7divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov7" name="fechanov7">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s7divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem7" name="justificarsem7" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s7divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s7fecharep1" name="s7fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s7divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s7fecharep2" name="s7fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Semana8 -->
        <?php
        $fechai8 = strtotime($objfechas->s8_rangoi);
        $fechaf8 = date("d-m-Y", strtotime($objfechas->s8_rangof . "+ 1 days"));
        $fechaf8 = strtotime($fechaf8);

        if ($fechahoy > $fechaf8 && ($objfechas->s8_tipoactividad == " " || $objfechas->s8_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem8" name="titulosem8" value="Semana 8" readonly>

                        <label class="col-md-1" for="rangoinicio8">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio8" name="rangoinicio8" value="<?php echo $objfechas->s8_rangoi; ?>" readonly>

                        <label for="rangofinal8" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal8" name="rangofinal8" value="<?php echo $objfechas->s8_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad8" name="TipoActividad8" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s8divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem8" name="DescripcionActSem8" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s8divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad8" name="TipoNovedad8" onchange="showopt2s8()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s8divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem8" name="justificasem8" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s8divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov8" name="fechanov8">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s8divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem8" name="justificarsem8" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s8divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s8fecharep1" name="s8fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s8divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s8fecharep2" name="s8fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana9 -->
        <?php
        $fechai9 = strtotime($objfechas->s9_rangoi);
        $fechaf9 = date("d-m-Y", strtotime($objfechas->s9_rangof . "+ 1 days"));
        $fechaf9 = strtotime($fechaf9);

        if ($fechahoy > $fechaf9 && ($objfechas->s9_tipoactividad == " " || $objfechas->s9_tipoactividad == null)) { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad9" name="TipoActividad9" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s9divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem9" name="DescripcionActSem9" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s9divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad9" name="TipoNovedad9" onchange="showopt2s9()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s9divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem9" name="justificasem9" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s9divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov9" name="fechanov9">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s9divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem9" name="justificarsem9" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s9divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s9fecharep1" name="s9fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s9divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s9fecharep2" name="s9fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana10 -->
        <?php
        $fechai10 = strtotime($objfechas->s10_rangoi);
        $fechaf10 = date("d-m-Y", strtotime($objfechas->s10_rangof . "+ 1 days"));
        $fechaf10 = strtotime($fechaf10);

        if ($fechahoy > $fechaf10 && ($objfechas->s10_tipoactividad == " " || $objfechas->s10_tipoactividad == null)) { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad10" name="TipoActividad10" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s10divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem10" name="DescripcionActSem10" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s10divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad10" name="TipoNovedad10" onchange="showopt2s10()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s10divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem10" name="justificasem10" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s10divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov10" name="fechanov10">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s10divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem10" name="justificarsem10" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s10divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s10fecharep1" name="s10fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s10divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s10fecharep2" name="s10fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Semana11 -->
        <?php
        $fechai11 = strtotime($objfechas->s11_rangoi);
        $fechaf11 = date("d-m-Y", strtotime($objfechas->s11_rangof . "+ 1 days"));
        $fechaf11 = strtotime($fechaf11);

        if ($fechahoy > $fechaf11 && ($objfechas->s11_tipoactividad == " " || $objfechas->s11_tipoactividad == null)) { ?>
            <div class="row border border-danger rounded">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <input type="text" class="inputClass col-md-2" id="titulosem11" name="titulosem11" value="Semana 11" readonly>

                        <label class="col-md-1" for="rangoinicio11">Del:</label>
                        <input type="text" class="col-md-2" id="rangoinicio11" name="rangoinicio11" value="<?php echo $objfechas->s11_rangoi; ?>" readonly>

                        <label for="rangofinal11" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal11" name="rangofinal11" value="<?php echo $objfechas->s11_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad11" name="TipoActividad11" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row" id="s11divopt1">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem11" name="DescripcionActSem11" placeholder="Descripcion" rows="6" required></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                    </div>
                </div>
                <div class="row" id="s11divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad11" name="TipoNovedad11" onchange="showopt2s11()" required>
                            <option value="" selected></option>
                            <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                            <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s11divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem11" name="justificasem11" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-4 mt-2" id="s11divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov11" name="fechanov11">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2" id="s11divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem11" name="justificarsem11" placeholder="Justificación" rows="2"></textarea>
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s11divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s11fecharep1" name="s11fecharep1">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                    </div>
                    <div class="col-md-3 mt-2" id="s11divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s11fecharep2" name="s11fecharep2">
                        <div class="valid-feedback">Campo Validado.</div>
                        <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                    </div>
                </div>
            </div>
        <?php } ?>

<!-- Semana12 -->
<?php
       $fechai12 = strtotime($objfechas->s12_rangoi);
       $fechaf12 = date("d-m-Y", strtotime($objfechas->s12_rangof . "+ 1 days"));
       $fechaf12 = strtotime($fechaf12);

       if ($fechahoy > $fechaf12 && ($objfechas->s12_tipoactividad == " " || $objfechas->s12_tipoactividad == null)) { ?>
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
                       <input type="text" class="form-control form-control sm" id="TipoActividad12" name="TipoActividad12" value="Novedad" readonly>
                   </div>
               </div>
               <div class="row" id="s12divopt1">
                   <div class="col-md-12 mt-2">
                       <h6><span class="badge bg-danger">Descripción</span></h6>
                       <textarea class="form-control" id="DescripcionActSem12" name="DescripcionActSem12" placeholder="Descripcion" rows="6" required></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                   </div>
               </div>
               <div class="row" id="s12divopt2">
                   <div class="col-md-4 mt-2">
                       <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                       <select class="form-select form-select-sm" id="TipoNovedad12" name="TipoNovedad12" onchange="showopt2s12()" required>
                           <option value="" selected></option>
                           <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                           <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                           <div class="valid-feedback">Campo Validado.</div>
                           <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                       </select>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-8 mt-2" id="s12divopt3" style="display: none">
                       <h6><span class="badge bg-danger">Justificación</span></h6>
                       <textarea class="form-control" id="justificasem12" name="justificasem12" placeholder="Justificación" rows="2"></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                   </div>
                   <div class="col-md-4 mt-2" id="s12divopt4" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                       <input type="date" class="form-control form-control sm" id="fechanov12" name="fechanov12">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6 mt-2" id="s12divopt7" style="display: none">
                       <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                       <textarea class="form-control" id="justificarsem12" name="justificarsem12" placeholder="Justificación" rows="2"></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                   </div>
                   <div class="col-md-3 mt-2" id="s12divopt5" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                       <input type="date" class="form-control form-control sm" id="s12fecharep1" name="s12fecharep1">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                   </div>
                   <div class="col-md-3 mt-2" id="s12divopt6" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                       <input type="date" class="form-control form-control sm" id="s12fecharep2" name="s12fecharep2">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                   </div>
               </div>
           </div>
       <?php } ?>
       <!-- Semana13 -->
       <?php
       $fechai13 = strtotime($objfechas->s13_rangoi);
       $fechaf13 = date("d-m-Y", strtotime($objfechas->s13_rangof . "+ 1 days"));
       $fechaf13 = strtotime($fechaf13);

       if ($fechahoy > $fechaf13 && ($objfechas->s13_tipoactividad == " " || $objfechas->s13_tipoactividad == null)) { ?>
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
                       <input type="text" class="form-control form-control sm" id="TipoActividad13" name="TipoActividad13" value="Novedad" readonly>
                   </div>
               </div>
               <div class="row" id="s13divopt1">
                   <div class="col-md-12 mt-2">
                       <h6><span class="badge bg-danger">Descripción</span></h6>
                       <textarea class="form-control" id="DescripcionActSem13" name="DescripcionActSem13" placeholder="Descripcion" rows="6" required></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                   </div>
               </div>
               <div class="row" id="s13divopt2">
                   <div class="col-md-4 mt-2">
                       <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                       <select class="form-select form-select-sm" id="TipoNovedad13" name="TipoNovedad13" onchange="showopt2s13()" required>
                           <option value="" selected></option>
                           <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                           <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                           <div class="valid-feedback">Campo Validado.</div>
                           <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                       </select>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-8 mt-2" id="s13divopt3" style="display: none">
                       <h6><span class="badge bg-danger">Justificación</span></h6>
                       <textarea class="form-control" id="justificasem13" name="justificasem13" placeholder="Justificación" rows="2"></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                   </div>
                   <div class="col-md-4 mt-2" id="s13divopt4" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                       <input type="date" class="form-control form-control sm" id="fechanov13" name="fechanov13">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6 mt-2" id="s13divopt7" style="display: none">
                       <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                       <textarea class="form-control" id="justificarsem13" name="justificarsem13" placeholder="Justificación" rows="2"></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                   </div>
                   <div class="col-md-3 mt-2" id="s13divopt5" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                       <input type="date" class="form-control form-control sm" id="s13fecharep1" name="s13fecharep1">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                   </div>
                   <div class="col-md-3 mt-2" id="s13divopt6" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                       <input type="date" class="form-control form-control sm" id="s13fecharep2" name="s13fecharep2">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                   </div>
               </div>
           </div>
       <?php } ?>
       <!-- Semana14 -->
       <?php
       $fechai14 = strtotime($objfechas->s14_rangoi);
       $fechaf14 = date("d-m-Y", strtotime($objfechas->s14_rangof . "+ 1 days"));
       $fechaf14 = strtotime($fechaf14);

       if ($fechahoy > $fechaf14 && ($objfechas->s14_tipoactividad == " " || $objfechas->s14_tipoactividad == null)) { ?>
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
                       <input type="text" class="form-control form-control sm" id="TipoActividad14" name="TipoActividad14" value="Novedad" readonly>
                   </div>
               </div>
               <div class="row" id="s14divopt1">
                   <div class="col-md-12 mt-2">
                       <h6><span class="badge bg-danger">Descripción</span></h6>
                       <textarea class="form-control" id="DescripcionActSem14" name="DescripcionActSem14" placeholder="Descripcion" rows="6" required></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                   </div>
               </div>
               <div class="row" id="s14divopt2">
                   <div class="col-md-4 mt-2">
                       <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                       <select class="form-select form-select-sm" id="TipoNovedad14" name="TipoNovedad14" onchange="showopt2s14()" required>
                           <option value="" selected></option>
                           <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                           <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                           <div class="valid-feedback">Campo Validado.</div>
                           <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                       </select>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-8 mt-2" id="s14divopt3" style="display: none">
                       <h6><span class="badge bg-danger">Justificación</span></h6>
                       <textarea class="form-control" id="justificasem14" name="justificasem14" placeholder="Justificación" rows="2"></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                   </div>
                   <div class="col-md-4 mt-2" id="s14divopt4" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                       <input type="date" class="form-control form-control sm" id="fechanov14" name="fechanov14">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6 mt-2" id="s14divopt7" style="display: none">
                       <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                       <textarea class="form-control" id="justificarsem14" name="justificarsem14" placeholder="Justificación" rows="2"></textarea>
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                   </div>
                   <div class="col-md-3 mt-2" id="s14divopt5" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                       <input type="date" class="form-control form-control sm" id="s14fecharep1" name="s14fecharep1">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                   </div>
                   <div class="col-md-3 mt-2" id="s14divopt6" style="display: none">
                       <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                       <input type="date" class="form-control form-control sm" id="s14fecharep2" name="s14fecharep2">
                       <div class="valid-feedback">Campo Validado.</div>
                       <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                   </div>
               </div>
           </div>
       <?php } ?>

       
<!-- Semana15 -->
<?php
$fechai15 = strtotime($objfechas->s15_rangoi);
$fechaf15 = date("d-m-Y", strtotime($objfechas->s15_rangof . "+ 1 days"));
$fechaf15 = strtotime($fechaf15);

if ($fechahoy > $fechaf15 && ($objfechas->s15_tipoactividad == " " || $objfechas->s15_tipoactividad == null)) { ?>
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
                <input type="text" class="form-control form-control sm" id="TipoActividad15" name="TipoActividad15" value="Novedad" readonly>
            </div>
        </div>
        <div class="row" id="s15divopt1">
            <div class="col-md-12 mt-2">
                <h6><span class="badge bg-danger">Descripción</span></h6>
                <textarea class="form-control" id="DescripcionActSem15" name="DescripcionActSem15" placeholder="Descripcion" rows="6" required></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
            </div>
        </div>
        <div class="row" id="s15divopt2">
            <div class="col-md-4 mt-2">
                <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                <select class="form-select form-select-sm" id="TipoNovedad15" name="TipoNovedad15" onchange="showopt2s15()" required>
                    <option value="" selected></option>
                    <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                    <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                    <div class="valid-feedback">Campo Validado.</div>
                    <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2" id="s15divopt3" style="display: none">
                <h6><span class="badge bg-danger">Justificación</span></h6>
                <textarea class="form-control" id="justificasem15" name="justificasem15" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-4 mt-2" id="s15divopt4" style="display: none">
                <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                <input type="date" class="form-control form-control sm" id="fechanov15" name="fechanov15">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2" id="s15divopt7" style="display: none">
                <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                <textarea class="form-control" id="justificarsem15" name="justificarsem15" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-3 mt-2" id="s15divopt5" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                <input type="date" class="form-control form-control sm" id="s15fecharep1" name="s15fecharep1">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
            </div>
            <div class="col-md-3 mt-2" id="s15divopt6" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                <input type="date" class="form-control form-control sm" id="s15fecharep2" name="s15fecharep2">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Semana16 -->
<?php
$fechai16 = strtotime($objfechas->s16_rangoi);
$fechaf16 = date("d-m-Y", strtotime($objfechas->s16_rangof . "+ 1 days"));
$fechaf16 = strtotime($fechaf16);

if ($fechahoy > $fechaf16 && ($objfechas->s16_tipoactividad == " " || $objfechas->s16_tipoactividad == null)) { ?>
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
                <input type="text" class="form-control form-control sm" id="TipoActividad16" name="TipoActividad16" value="Novedad" readonly>
            </div>
        </div>
        <div class="row" id="s16divopt1">
            <div class="col-md-12 mt-2">
                <h6><span class="badge bg-danger">Descripción</span></h6>
                <textarea class="form-control" id="DescripcionActSem16" name="DescripcionActSem16" placeholder="Descripcion" rows="6" required></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
            </div>
        </div>
        <div class="row" id="s16divopt2">
            <div class="col-md-4 mt-2">
                <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                <select class="form-select form-select-sm" id="TipoNovedad16" name="TipoNovedad16" onchange="showopt2s16()" required>
                    <option value="" selected></option>
                    <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                    <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                    <div class="valid-feedback">Campo Validado.</div>
                    <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2" id="s16divopt3" style="display: none">
                <h6><span class="badge bg-danger">Justificación</span></h6>
                <textarea class="form-control" id="justificasem16" name="justificasem16" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-4 mt-2" id="s16divopt4" style="display: none">
                <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                <input type="date" class="form-control form-control sm" id="fechanov16" name="fechanov16">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2" id="s16divopt7" style="display: none">
                <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                <textarea class="form-control" id="justificarsem16" name="justificarsem16" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-3 mt-2" id="s16divopt5" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                <input type="date" class="form-control form-control sm" id="s16fecharep1" name="s16fecharep1">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
            </div>
            <div class="col-md-3 mt-2" id="s16divopt6" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                <input type="date" class="form-control form-control sm" id="s16fecharep2" name="s16fecharep2">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Semana17 -->
<?php
$fechai17 = strtotime($objfechas->s17_rangoi);
$fechaf17 = date("d-m-Y", strtotime($objfechas->s17_rangof . "+ 1 days"));
$fechaf17 = strtotime($fechaf17);

if ($fechahoy > $fechaf17 && ($objfechas->s17_tipoactividad == " " || $objfechas->s17_tipoactividad == null)) { ?>
    <div class="row border border-danger rounded">
        <div class="row">
            <div class="col-md-8 mt-2">
                <input type="text" class="inputClass col-md-2" id="titulosem17" name="titulosem17" value="Semana 17" readonly>

                <label class="col-md-1" for="rangoinicio17">Del:</label>
                <input type="text" class="col-md-2" id="rangoinicio17" name="rangoinicio17" value="<?php echo $objfechas->s17_rangoi; ?>" readonly>

                <label for="rangofinal17" class="col-md-1">Al:</label>
                <input type="text" class="col-md-2" id="rangofinal17" name="rangofinal17" value="<?php echo $objfechas->s17_rangof; ?>" readonly>
            </div>
            <div class="col-md-4 mt-2">
                <input type="text" class="form-control form-control sm" id="TipoActividad17" name="TipoActividad17" value="Novedad" readonly>
            </div>
        </div>
        <div class="row" id="s17divopt1">
            <div class="col-md-12 mt-2">
                <h6><span class="badge bg-danger">Descripción</span></h6>
                <textarea class="form-control" id="DescripcionActSem17" name="DescripcionActSem17" placeholder="Descripcion" rows="6" required></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
            </div>
        </div>
        <div class="row" id="s17divopt2">
            <div class="col-md-4 mt-2">
                <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                <select class="form-select form-select-sm" id="TipoNovedad17" name="TipoNovedad17" onchange="showopt2s17()" required>
                    <option value="" selected></option>
                    <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                    <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                    <div class="valid-feedback">Campo Validado.</div>
                    <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2" id="s17divopt3" style="display: none">
                <h6><span class="badge bg-danger">Justificación</span></h6>
                <textarea class="form-control" id="justificasem17" name="justificasem17" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-4 mt-2" id="s17divopt4" style="display: none">
                <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                <input type="date" class="form-control form-control sm" id="fechanov17" name="fechanov17">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2" id="s17divopt7" style="display: none">
                <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                <textarea class="form-control" id="justificarsem17" name="justificarsem17" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-3 mt-2" id="s17divopt5" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                <input type="date" class="form-control form-control sm" id="s17fecharep1" name="s17fecharep1">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
            </div>
            <div class="col-md-3 mt-2" id="s17divopt6" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                <input type="date" class="form-control form-control sm" id="s17fecharep2" name="s17fecharep2">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Semana18 -->
<?php
$fechai18 = strtotime($objfechas->s18_rangoi);
$fechaf18 = date("d-m-Y", strtotime($objfechas->s18_rangof . "+ 1 days"));
$fechaf18 = strtotime($fechaf18);

if ($fechahoy > $fechaf18 && ($objfechas->s18_tipoactividad == " " || $objfechas->s18_tipoactividad == null)) { ?>
    <div class="row border border-danger rounded">
        <div class="row">
            <div class="col-md-8 mt-2">
                <input type="text" class="inputClass col-md-2" id="titulosem18" name="titulosem18" value="Semana 18" readonly>

                <label class="col-md-1" for="rangoinicio18">Del:</label>
                <input type="text" class="col-md-2" id="rangoinicio18" name="rangoinicio18" value="<?php echo $objfechas->s18_rangoi; ?>" readonly>

                <label for="rangofinal18" class="col-md-1">Al:</label>
                <input type="text" class="col-md-2" id="rangofinal18" name="rangofinal18" value="<?php echo $objfechas->s18_rangof; ?>" readonly>
            </div>
            <div class="col-md-4 mt-2">
                <input type="text" class="form-control form-control sm" id="TipoActividad18" name="TipoActividad18" value="Novedad" readonly>
            </div>
        </div>
        <div class="row" id="s18divopt1">
            <div class="col-md-12 mt-2">
                <h6><span class="badge bg-danger">Descripción</span></h6>
                <textarea class="form-control" id="DescripcionActSem18" name="DescripcionActSem18" placeholder="Descripcion" rows="6" required></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
            </div>
        </div>
        <div class="row" id="s18divopt2">
            <div class="col-md-4 mt-2">
                <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                <select class="form-select form-select-sm" id="TipoNovedad18" name="TipoNovedad18" onchange="showopt2s18()" required>
                    <option value="" selected></option>
                    <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                    <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                    <div class="valid-feedback">Campo Validado.</div>
                    <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2" id="s18divopt3" style="display: none">
                <h6><span class="badge bg-danger">Justificación</span></h6>
                <textarea class="form-control" id="justificasem18" name="justificasem18" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-4 mt-2" id="s18divopt4" style="display: none">
                <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                <input type="date" class="form-control form-control sm" id="fechanov18" name="fechanov18">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2" id="s18divopt7" style="display: none">
                <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                <textarea class="form-control" id="justificarsem18" name="justificarsem18" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-3 mt-2" id="s18divopt5" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                <input type="date" class="form-control form-control sm" id="s18fecharep1" name="s18fecharep1">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
            </div>
            <div class="col-md-3 mt-2" id="s18divopt6" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                <input type="date" class="form-control form-control sm" id="s18fecharep2" name="s18fecharep2">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
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

            <!-- Semana1p -->
            <?php
            $fechai1p = strtotime($objfechas->s1p_rangoi);
            $fechaf1p = date("d-m-Y", strtotime($objfechas->s1p_rangof . "+ 1 days"));
            $fechaf1p = strtotime($fechaf1p);

            if ($fechahoy > $fechaf1p && ($objfechas->s1p_tipoactividad == " " || $objfechas->s1p_tipoactividad == null)) { ?>
                <div class="row border border-danger rounded">
                    <div class="row">
                        <div class="col-md-8 mt-2">
                            <input type="text" class="inputClass col-md-2" id="titulosem1p" name="titulosem1p" value="Semana 1p" readonly>

                            <label class="col-md-1" for="rangoinicio1p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio1p" name="rangoinicio1p" value="<?php echo $objfechas->s1p_rangoi; ?>" readonly>

                            <label for="rangofinal1p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal1p" name="rangofinal1p" value="<?php echo $objfechas->s1p_rangof; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="text" class="form-control form-control sm" id="TipoActividad1p" name="TipoActividad1p" value="Novedad" readonly>
                        </div>
                    </div>
                    <div class="row" id="s1pdivopt1">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem1p" name="DescripcionActSem1p" placeholder="Descripcion" rows="6" required></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                        </div>
                    </div>
                    <div class="row" id="s1pdivopt2">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad1p" name="TipoNovedad1p" onchange="showopt2s1p()" required>
                                <option value="" selected></option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                                <div class="valid-feedback">Campo Validado.</div>
                                <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s1pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem1p" name="justificasem1p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-4 mt-2" id="s1pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov1p" name="fechanov1p">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s1pdivopt7" style="display: none">
                            <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                            <textarea class="form-control" id="justificarsem1p" name="justificarsem1p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s1pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                            <input type="date" class="form-control form-control sm" id="s1pfecharep1" name="s1pfecharep1">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s1pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                            <input type="date" class="form-control form-control sm" id="s1pfecharep2" name="s1pfecharep2">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana2p -->
            <?php
            $fechai2p = strtotime($objfechas->s2p_rangoi);
            $fechaf2p = date("d-m-Y", strtotime($objfechas->s2p_rangof . "+ 1 days"));
            $fechaf2p = strtotime($fechaf2p);

            if ($fechahoy > $fechaf2p && ($objfechas->s2p_tipoactividad == " " || $objfechas->s2p_tipoactividad == null)) { ?>
                <div class="row border border-danger rounded">
                    <div class="row">
                        <div class="col-md-8 mt-2">
                            <input type="text" class="inputClass col-md-2" id="titulosem2p" name="titulosem2p" value="Semana 2p" readonly>

                            <label class="col-md-1" for="rangoinicio2p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio2p" name="rangoinicio2p" value="<?php echo $objfechas->s2p_rangoi; ?>" readonly>

                            <label for="rangofinal2p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal2p" name="rangofinal2p" value="<?php echo $objfechas->s2p_rangof; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="text" class="form-control form-control sm" id="TipoActividad2p" name="TipoActividad2p" value="Novedad" readonly>
                        </div>
                    </div>
                    <div class="row" id="s2pdivopt1">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem2p" name="DescripcionActSem2p" placeholder="Descripcion" rows="6" required></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                        </div>
                    </div>
                    <div class="row" id="s2pdivopt2">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad2p" name="TipoNovedad2p" onchange="showopt2s2p()" required>
                                <option value="" selected></option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                                <div class="valid-feedback">Campo Validado.</div>
                                <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s2pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem2p" name="justificasem2p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-4 mt-2" id="s2pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov2p" name="fechanov2p">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s2pdivopt7" style="display: none">
                            <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                            <textarea class="form-control" id="justificarsem2p" name="justificarsem2p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s2pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                            <input type="date" class="form-control form-control sm" id="s2pfecharep1" name="s2pfecharep1">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s2pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                            <input type="date" class="form-control form-control sm" id="s2pfecharep2" name="s2pfecharep2">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana4p -->
            <?php
            $fechai4p = strtotime($objfechas->s4p_rangoi);
            $fechaf4p = date("d-m-Y", strtotime($objfechas->s4p_rangof . "+ 1 days"));
            $fechaf4p = strtotime($fechaf4p);

            if ($fechahoy > $fechaf4p && ($objfechas->s4p_tipoactividad == " " || $objfechas->s4p_tipoactividad == null)) { ?>
                <div class="row border border-danger rounded">
                    <div class="row">
                        <div class="col-md-8 mt-2">
                            <input type="text" class="inputClass col-md-2" id="titulosem4p" name="titulosem4p" value="Semana 4p" readonly>

                            <label class="col-md-1" for="rangoinicio4p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio4p" name="rangoinicio4p" value="<?php echo $objfechas->s4p_rangoi; ?>" readonly>

                            <label for="rangofinal4p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal4p" name="rangofinal4p" value="<?php echo $objfechas->s4p_rangof; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="text" class="form-control form-control sm" id="TipoActividad4p" name="TipoActividad4p" value="Novedad" readonly>
                        </div>
                    </div>
                    <div class="row" id="s4pdivopt1">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem4p" name="DescripcionActSem4p" placeholder="Descripcion" rows="6" required></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                        </div>
                    </div>
                    <div class="row" id="s4pdivopt2">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad4p" name="TipoNovedad4p" onchange="showopt2s4p()" required>
                                <option value="" selected></option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                                <div class="valid-feedback">Campo Validado.</div>
                                <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s4pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem4p" name="justificasem4p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-4 mt-2" id="s4pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov4p" name="fechanov4p">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s4pdivopt7" style="display: none">
                            <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                            <textarea class="form-control" id="justificarsem4p" name="justificarsem4p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s4pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                            <input type="date" class="form-control form-control sm" id="s4pfecharep1" name="s4pfecharep1">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s4pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                            <input type="date" class="form-control form-control sm" id="s4pfecharep2" name="s4pfecharep2">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana4p -->
            <?php
            $fechai4p = strtotime($objfechas->s4p_rangoi);
            $fechaf4p = date("d-m-Y", strtotime($objfechas->s4p_rangof . "+ 1 days"));
            $fechaf4p = strtotime($fechaf4p);

            if ($fechahoy > $fechaf4p && ($objfechas->s4p_tipoactividad == " " || $objfechas->s4p_tipoactividad == null)) { ?>
                <div class="row border border-danger rounded">
                    <div class="row">
                        <div class="col-md-8 mt-2">
                            <input type="text" class="inputClass col-md-2" id="titulosem4p" name="titulosem4p" value="Semana 4p" readonly>

                            <label class="col-md-1" for="rangoinicio4p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio4p" name="rangoinicio4p" value="<?php echo $objfechas->s4p_rangoi; ?>" readonly>

                            <label for="rangofinal4p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal4p" name="rangofinal4p" value="<?php echo $objfechas->s4p_rangof; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="text" class="form-control form-control sm" id="TipoActividad4p" name="TipoActividad4p" value="Novedad" readonly>
                        </div>
                    </div>
                    <div class="row" id="s4pdivopt1">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem4p" name="DescripcionActSem4p" placeholder="Descripcion" rows="6" required></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                        </div>
                    </div>
                    <div class="row" id="s4pdivopt2">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad4p" name="TipoNovedad4p" onchange="showopt2s4p()" required>
                                <option value="" selected></option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                                <div class="valid-feedback">Campo Validado.</div>
                                <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s4pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem4p" name="justificasem4p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-4 mt-2" id="s4pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov4p" name="fechanov4p">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s4pdivopt7" style="display: none">
                            <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                            <textarea class="form-control" id="justificarsem4p" name="justificarsem4p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s4pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                            <input type="date" class="form-control form-control sm" id="s4pfecharep1" name="s4pfecharep1">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s4pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                            <input type="date" class="form-control form-control sm" id="s4pfecharep2" name="s4pfecharep2">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Semana5p -->
            <?php
            $fechai5p = strtotime($objfechas->s5p_rangoi);
            $fechaf5p = date("d-m-Y", strtotime($objfechas->s5p_rangof . "+ 1 days"));
            $fechaf5p = strtotime($fechaf5p);

            if ($fechahoy > $fechaf5p && ($objfechas->s5p_tipoactividad == " " || $objfechas->s5p_tipoactividad == null)) { ?>
                <div class="row border border-danger rounded">
                    <div class="row">
                        <div class="col-md-8 mt-2">
                            <input type="text" class="inputClass col-md-2" id="titulosem5p" name="titulosem5p" value="Semana 5p" readonly>

                            <label class="col-md-1" for="rangoinicio5p">Del:</label>
                            <input type="text" class="col-md-2" id="rangoinicio5p" name="rangoinicio5p" value="<?php echo $objfechas->s5p_rangoi; ?>" readonly>

                            <label for="rangofinal5p" class="col-md-1">Al:</label>
                            <input type="text" class="col-md-2" id="rangofinal5p" name="rangofinal5p" value="<?php echo $objfechas->s5p_rangof; ?>" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="text" class="form-control form-control sm" id="TipoActividad5p" name="TipoActividad5p" value="Novedad" readonly>
                        </div>
                    </div>
                    <div class="row" id="s5pdivopt1">
                        <div class="col-md-12 mt-2">
                            <h6><span class="badge bg-danger">Descripción</span></h6>
                            <textarea class="form-control" id="DescripcionActSem5p" name="DescripcionActSem5p" placeholder="Descripcion" rows="6" required></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
                        </div>
                    </div>
                    <div class="row" id="s5pdivopt2">
                        <div class="col-md-4 mt-2">
                            <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                            <select class="form-select form-select-sm" id="TipoNovedad5p" name="TipoNovedad5p" onchange="showopt2s5p()" required>
                                <option value="" selected></option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                                <div class="valid-feedback">Campo Validado.</div>
                                <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-2" id="s5pdivopt3" style="display: none">
                            <h6><span class="badge bg-danger">Justificación</span></h6>
                            <textarea class="form-control" id="justificasem5p" name="justificasem5p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-4 mt-2" id="s5pdivopt4" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                            <input type="date" class="form-control form-control sm" id="fechanov5p" name="fechanov5p">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2" id="s5pdivopt7" style="display: none">
                            <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                            <textarea class="form-control" id="justificarsem5p" name="justificarsem5p" placeholder="Justificación" rows="2"></textarea>
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Justificación.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s5pdivopt5" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                            <input type="date" class="form-control form-control sm" id="s5pfecharep1" name="s5pfecharep1">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
                        </div>
                        <div class="col-md-3 mt-2" id="s5pdivopt6" style="display: none">
                            <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                            <input type="date" class="form-control form-control sm" id="s5pfecharep2" name="s5pfecharep2">
                            <div class="valid-feedback">Campo Validado.</div>
                            <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!--Hastaaqui -->
        <?php
    } ?>