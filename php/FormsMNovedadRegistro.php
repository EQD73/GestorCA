<?php

date_default_timezone_set("America/Bogota");
session_start();
include('conextemp.php');

//temporal

/* $query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
$resultado_temp = pg_query($conexion2, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$codigoConsulta = $obj_temp->valor2; */

$tablam3 = $_SESSION['tablam3'];
$codigoConsulta= $_SESSION['codigoConsulta'];

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
        <!-- semana 1 -->
        <!-- Semana1 -->
<?php
        $fechai1 = strtotime($objfechas->s1_rangoi);
        $fechaf1 = date("d-m-Y", strtotime($objfechas->s1_rangof . "+ 1 days"));
        $fechaf1 = strtotime($fechaf1);

        //if ($fechahoy >= $fechai1 &&  $fechahoy <= $fechaf1) { 
        if ($objfechas->s1_descripcion <> " " &&  $objfechas->s1_tipoactividad == "Novedad") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad1" name="TipoActividad1" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem1" name="DescripcionActSem1" placeholder="Descripcion" rows="6"><?php echo $objfechas->s1_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s1divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad1" name="TipoNovedad1" onfocus="showopt2s1();" onchange="showopt2s1();">
                            
                            <option value="<?php echo $objfechas->s1_tiponovedad; ?>" selected><?php if ($objfechas->s1_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s1_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s1_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s1_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s1_tiponovedad == " " or empty($objfechas->s1_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad1').value != " ") {
                        $("#TipoNovedad1").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s1divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem1" name="justificasem1" placeholder="Justificación" rows="2"><?php echo $objfechas->s1_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s1divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov1" name="fechanov1" value="<?php echo $objfechas->s1_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s1divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem1" name="justificarsem1" placeholder="Justificación" rows="2"><?php echo $objfechas->s1_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2" id="s1divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s1fecharep1" name="s1fecharep1" value="<?php echo $objfechas->s1_fechareprog1; ?>">
                    </div>
                    <div class="col-md-3 mt-2" id="s1divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s1fecharep2" name="s1fecharep2" value="<?php echo $objfechas->s1_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana2 -->
        <?php
        $fechai2 = strtotime($objfechas->s2_rangoi);
        $fechaf2 = date("d-m-Y", strtotime($objfechas->s2_rangof . "+ 1 days"));
        $fechaf2 = strtotime($fechaf2);

        if ($objfechas->s2_descripcion <> " " &&  $objfechas->s2_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
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
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem2" name="DescripcionActSem2" placeholder="Descripcion" rows="6"><?php echo $objfechas->s2_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s2divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad2" name="TipoNovedad2" onfocus="showopt2s2();" onchange="showopt2s2();">
                            
                            <option value="<?php echo $objfechas->s2_tiponovedad; ?>" selected><?php if ($objfechas->s2_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s2_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s2_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s2_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s2_tiponovedad == " " or empty($objfechas->s2_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad2').value != " ") {
                        $("#TipoNovedad2").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s2divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem2" name="justificasem2" placeholder="Justificación" rows="2"><?php echo $objfechas->s2_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s2divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov2" name="fechanov2" value="<?php echo $objfechas->s2_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s2divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem2" name="justificarsem2" placeholder="Justificación" rows="2"><?php echo $objfechas->s2_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-3 mt-2" id="s2divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s2fecharep1" name="s2fecharep1" value="<?php echo $objfechas->s2_fechareprog1; ?>">
                    </div>
                    <div class="col-md-3 mt-2" id="s2divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s2fecharep2" name="s2fecharep2" value="<?php echo $objfechas->s2_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana3 -->
      
<?php
        $fechai3 = strtotime($objfechas->s3_rangoi);
        $fechaf3 = date("d-m-Y", strtotime($objfechas->s3_rangof . "+ 1 days"));
        $fechaf3 = strtotime($fechaf3);

        if ($objfechas->s3_descripcion <> " " &&  $objfechas->s3_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem3" name="titulosem3" value="Semana 3" readonly>

                        <label class="col-md-1" for="rangoinicio3">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio3" name="rangoinicio3" value="<?php echo $objfechas->s3_rangoi; ?>" readonly>

                        <label for="rangofinal3" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal3" name="rangofinal3" value="<?php echo $objfechas->s3_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad3" name="TipoActividad3" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem3" name="DescripcionActSem3" placeholder="Descripcion" rows="6"><?php echo $objfechas->s3_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s3divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad3" name="TipoNovedad3" onfocus="showopt2s3();" onchange="showopt2s3();">
                            
                            <option value="<?php echo $objfechas->s3_tiponovedad; ?>" selected><?php if ($objfechas->s3_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s3_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s3_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s3_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s3_tiponovedad == " " or empty($objfechas->s3_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad3').value != " ") {
                        $("#TipoNovedad3").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s3divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem3" name="justificasem3" placeholder="Justificación" rows="2"><?php echo $objfechas->s3_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s3divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov3" name="fechanov3" value="<?php echo $objfechas->s3_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s3divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem3" name="justificarsem3" placeholder="Justificación" rows="2"><?php echo $objfechas->s3_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s3divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3fecharep1" name="s3fecharep1" value="<?php echo $objfechas->s3_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s3divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3fecharep2" name="s3fecharep2" value="<?php echo $objfechas->s3_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana4 -->
        <?php
        $fechai4 = strtotime($objfechas->s4_rangoi);
        $fechaf4 = date("d-m-Y", strtotime($objfechas->s4_rangof . "+ 1 days"));
        $fechaf4 = strtotime($fechaf4);

        if ($objfechas->s4_descripcion <> " " &&  $objfechas->s4_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem4" name="titulosem4" value="Semana 4" readonly>

                        <label class="col-md-1" for="rangoinicio4">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio4" name="rangoinicio4" value="<?php echo $objfechas->s4_rangoi; ?>" readonly>

                        <label for="rangofinal4" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal4" name="rangofinal4" value="<?php echo $objfechas->s4_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad4" name="TipoActividad4" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem4" name="DescripcionActSem4" placeholder="Descripcion" rows="6"><?php echo $objfechas->s4_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s4divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad4" name="TipoNovedad4" onfocus="showopt2s4();" onchange="showopt2s4();">
                            
                            <option value="<?php echo $objfechas->s4_tiponovedad; ?>" selected><?php if ($objfechas->s4_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s4_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s4_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s4_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s4_tiponovedad == " " or empty($objfechas->s4_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad4').value != " ") {
                        $("#TipoNovedad4").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s4divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem4" name="justificasem4" placeholder="Justificación" rows="2"><?php echo $objfechas->s4_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s4divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov4" name="fechanov4" value="<?php echo $objfechas->s4_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s4divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem4" name="justificarsem4" placeholder="Justificación" rows="2"><?php echo $objfechas->s4_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s4divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s4fecharep1" name="s4fecharep1" value="<?php echo $objfechas->s4_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s4divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s4fecharep2" name="s4fecharep2" value="<?php echo $objfechas->s4_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana5 -->
        <?php
        $fechai5 = strtotime($objfechas->s5_rangoi);
        $fechaf5 = date("d-m-Y", strtotime($objfechas->s5_rangof . "+ 1 days"));
        $fechaf5 = strtotime($fechaf5);

        if ($objfechas->s5_descripcion <> " " &&  $objfechas->s5_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem5" name="titulosem5" value="Semana 5" readonly>

                        <label class="col-md-1" for="rangoinicio5">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio5" name="rangoinicio5" value="<?php echo $objfechas->s5_rangoi; ?>" readonly>

                        <label for="rangofinal5" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal5" name="rangofinal5" value="<?php echo $objfechas->s5_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad5" name="TipoActividad5" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem5" name="DescripcionActSem5" placeholder="Descripcion" rows="6"><?php echo $objfechas->s5_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s5divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad5" name="TipoNovedad5" onfocus="showopt2s5();" onchange="showopt2s5();">
                            
                            <option value="<?php echo $objfechas->s5_tiponovedad; ?>" selected><?php if ($objfechas->s5_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s5_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s5_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s5_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s5_tiponovedad == " " or empty($objfechas->s5_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad5').value != " ") {
                        $("#TipoNovedad5").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s5divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem5" name="justificasem5" placeholder="Justificación" rows="2"><?php echo $objfechas->s5_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s5divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov5" name="fechanov5" value="<?php echo $objfechas->s5_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s5divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem5" name="justificarsem5" placeholder="Justificación" rows="2"><?php echo $objfechas->s5_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s5divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s5fecharep1" name="s5fecharep1" value="<?php echo $objfechas->s5_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s5divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s5fecharep2" name="s5fecharep2" value="<?php echo $objfechas->s5_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana6 -->
        <?php
        $fechai6 = strtotime($objfechas->s6_rangoi);
        $fechaf6 = date("d-m-Y", strtotime($objfechas->s6_rangof . "+ 1 days"));
        $fechaf6 = strtotime($fechaf6);

        if ($objfechas->s6_descripcion <> " " &&  $objfechas->s6_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem6" name="titulosem6" value="Semana 6" readonly>

                        <label class="col-md-1" for="rangoinicio6">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio6" name="rangoinicio6" value="<?php echo $objfechas->s6_rangoi; ?>" readonly>

                        <label for="rangofinal6" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal6" name="rangofinal6" value="<?php echo $objfechas->s6_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad6" name="TipoActividad6" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem6" name="DescripcionActSem6" placeholder="Descripcion" rows="6"><?php echo $objfechas->s6_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s6divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad6" name="TipoNovedad6" onfocus="showopt2s6();" onchange="showopt2s6();">
                            
                            <option value="<?php echo $objfechas->s6_tiponovedad; ?>" selected><?php if ($objfechas->s6_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s6_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s6_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s6_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s6_tiponovedad == " " or empty($objfechas->s6_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad6').value != " ") {
                        $("#TipoNovedad6").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s6divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem6" name="justificasem6" placeholder="Justificación" rows="2"><?php echo $objfechas->s6_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s6divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov6" name="fechanov6" value="<?php echo $objfechas->s6_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s6divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem6" name="justificarsem6" placeholder="Justificación" rows="2"><?php echo $objfechas->s6_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s6divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s6fecharep1" name="s6fecharep1" value="<?php echo $objfechas->s6_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s6divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s6fecharep2" name="s6fecharep2" value="<?php echo $objfechas->s6_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana7 -->
        <?php
        $fechai7 = strtotime($objfechas->s7_rangoi);
        $fechaf7 = date("d-m-Y", strtotime($objfechas->s7_rangof . "+ 1 days"));
        $fechaf7 = strtotime($fechaf7);

        if ($objfechas->s7_descripcion <> " " &&  $objfechas->s7_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem7" name="titulosem7" value="Semana 7" readonly>

                        <label class="col-md-1" for="rangoinicio7">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio7" name="rangoinicio7" value="<?php echo $objfechas->s7_rangoi; ?>" readonly>

                        <label for="rangofinal7" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal7" name="rangofinal7" value="<?php echo $objfechas->s7_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad7" name="TipoActividad7" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem7" name="DescripcionActSem7" placeholder="Descripcion" rows="6"><?php echo $objfechas->s7_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s7divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad7" name="TipoNovedad7" onfocus="showopt2s7();" onchange="showopt2s7();">
                            
                            <option value="<?php echo $objfechas->s7_tiponovedad; ?>" selected><?php if ($objfechas->s7_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s7_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s7_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s7_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s7_tiponovedad == " " or empty($objfechas->s7_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad7').value != " ") {
                        $("#TipoNovedad7").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s7divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem7" name="justificasem7" placeholder="Justificación" rows="2"><?php echo $objfechas->s7_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s7divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov7" name="fechanov7" value="<?php echo $objfechas->s7_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s7divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem7" name="justificarsem7" placeholder="Justificación" rows="2"><?php echo $objfechas->s7_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s7divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s7fecharep1" name="s7fecharep1" value="<?php echo $objfechas->s7_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s7divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s7fecharep2" name="s7fecharep2" value="<?php echo $objfechas->s7_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana8 -->
        <?php
        $fechai8 = strtotime($objfechas->s8_rangoi);
        $fechaf8 = date("d-m-Y", strtotime($objfechas->s8_rangof . "+ 1 days"));
        $fechaf8 = strtotime($fechaf8);

        if ($objfechas->s8_descripcion <> " " &&  $objfechas->s8_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem8" name="titulosem8" value="Semana 8" readonly>

                        <label class="col-md-1" for="rangoinicio8">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio8" name="rangoinicio8" value="<?php echo $objfechas->s8_rangoi; ?>" readonly>

                        <label for="rangofinal8" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal8" name="rangofinal8" value="<?php echo $objfechas->s8_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad8" name="TipoActividad8" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem8" name="DescripcionActSem8" placeholder="Descripcion" rows="6"><?php echo $objfechas->s8_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s8divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad8" name="TipoNovedad8" onfocus="showopt2s8();" onchange="showopt2s8();">
                            
                            <option value="<?php echo $objfechas->s8_tiponovedad; ?>" selected><?php if ($objfechas->s8_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s8_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s8_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s8_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s8_tiponovedad == " " or empty($objfechas->s8_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad8').value != " ") {
                        $("#TipoNovedad8").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s8divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem8" name="justificasem8" placeholder="Justificación" rows="2"><?php echo $objfechas->s8_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s8divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov8" name="fechanov8" value="<?php echo $objfechas->s8_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s8divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem8" name="justificarsem8" placeholder="Justificación" rows="2"><?php echo $objfechas->s8_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s8divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s8fecharep1" name="s8fecharep1" value="<?php echo $objfechas->s8_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s8divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s8fecharep2" name="s8fecharep2" value="<?php echo $objfechas->s8_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana9 -->
        <?php
        $fechai9 = strtotime($objfechas->s9_rangoi);
        $fechaf9 = date("d-m-Y", strtotime($objfechas->s9_rangof . "+ 1 days"));
        $fechaf9 = strtotime($fechaf9);

        if ($objfechas->s9_descripcion <> " " &&  $objfechas->s9_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem9" name="titulosem9" value="Semana 9" readonly>

                        <label class="col-md-1" for="rangoinicio9">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio9" name="rangoinicio9" value="<?php echo $objfechas->s9_rangoi; ?>" readonly>

                        <label for="rangofinal9" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal9" name="rangofinal9" value="<?php echo $objfechas->s9_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad9" name="TipoActividad9" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem9" name="DescripcionActSem9" placeholder="Descripcion" rows="6"><?php echo $objfechas->s9_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s9divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad9" name="TipoNovedad9" onfocus="showopt2s9();" onchange="showopt2s9();">
                            
                            <option value="<?php echo $objfechas->s9_tiponovedad; ?>" selected><?php if ($objfechas->s9_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s9_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s9_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s9_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s9_tiponovedad == " " or empty($objfechas->s9_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad9').value != " ") {
                        $("#TipoNovedad9").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s9divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem9" name="justificasem9" placeholder="Justificación" rows="2"><?php echo $objfechas->s9_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s9divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov9" name="fechanov9" value="<?php echo $objfechas->s9_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s9divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem9" name="justificarsem9" placeholder="Justificación" rows="2"><?php echo $objfechas->s9_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s9divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s9fecharep1" name="s9fecharep1" value="<?php echo $objfechas->s9_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s9divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s9fecharep2" name="s9fecharep2" value="<?php echo $objfechas->s9_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana10 -->
        <?php
        $fechai10 = strtotime($objfechas->s10_rangoi);
        $fechaf10 = date("d-m-Y", strtotime($objfechas->s10_rangof . "+ 1 days"));
        $fechaf10 = strtotime($fechaf10);

        if ($objfechas->s10_descripcion <> " " &&  $objfechas->s10_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem10" name="titulosem10" value="Semana 10" readonly>

                        <label class="col-md-1" for="rangoinicio10">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio10" name="rangoinicio10" value="<?php echo $objfechas->s10_rangoi; ?>" readonly>

                        <label for="rangofinal10" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal10" name="rangofinal10" value="<?php echo $objfechas->s10_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad10" name="TipoActividad10" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem10" name="DescripcionActSem10" placeholder="Descripcion" rows="6"><?php echo $objfechas->s10_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s10divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad10" name="TipoNovedad10" onfocus="showopt2s10();" onchange="showopt2s10();">
                            
                            <option value="<?php echo $objfechas->s10_tiponovedad; ?>" selected><?php if ($objfechas->s10_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s10_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s10_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s10_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s10_tiponovedad == " " or empty($objfechas->s10_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad10').value != " ") {
                        $("#TipoNovedad10").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s10divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem10" name="justificasem10" placeholder="Justificación" rows="2"><?php echo $objfechas->s10_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s10divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov10" name="fechanov10" value="<?php echo $objfechas->s10_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s10divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem10" name="justificarsem10" placeholder="Justificación" rows="2"><?php echo $objfechas->s10_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s10divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s10fecharep1" name="s10fecharep1" value="<?php echo $objfechas->s10_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s10divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s10fecharep2" name="s10fecharep2" value="<?php echo $objfechas->s10_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        
        <!-- Semana11 -->
        <?php
        $fechai11 = strtotime($objfechas->s11_rangoi);
        $fechaf11 = date("d-m-Y", strtotime($objfechas->s11_rangof . "+ 1 days"));
        $fechaf11 = strtotime($fechaf11);

        if ($objfechas->s11_descripcion <> " " &&  $objfechas->s11_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem11" name="titulosem11" value="Semana 11" readonly>

                        <label class="col-md-1" for="rangoinicio11">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio11" name="rangoinicio11" value="<?php echo $objfechas->s11_rangoi; ?>" readonly>

                        <label for="rangofinal11" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal11" name="rangofinal11" value="<?php echo $objfechas->s11_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad11" name="TipoActividad11" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem11" name="DescripcionActSem11" placeholder="Descripcion" rows="6"><?php echo $objfechas->s11_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s11divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad11" name="TipoNovedad11" onfocus="showopt2s11();" onchange="showopt2s11();">
                            
                            <option value="<?php echo $objfechas->s11_tiponovedad; ?>" selected><?php if ($objfechas->s11_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s11_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s11_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s11_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s11_tiponovedad == " " or empty($objfechas->s11_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad11').value != " ") {
                        $("#TipoNovedad11").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s11divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem11" name="justificasem11" placeholder="Justificación" rows="2"><?php echo $objfechas->s11_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s11divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov11" name="fechanov11" value="<?php echo $objfechas->s11_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s11divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem11" name="justificarsem11" placeholder="Justificación" rows="2"><?php echo $objfechas->s11_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s11divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s11fecharep1" name="s11fecharep1" value="<?php echo $objfechas->s11_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s11divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s11fecharep2" name="s11fecharep2" value="<?php echo $objfechas->s11_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana12 -->
        <?php
        $fechai12 = strtotime($objfechas->s12_rangoi);
        $fechaf12 = date("d-m-Y", strtotime($objfechas->s12_rangof . "+ 1 days"));
        $fechaf12 = strtotime($fechaf12);

        if ($objfechas->s12_descripcion <> " " &&  $objfechas->s12_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem12" name="titulosem12" value="Semana 12" readonly>

                        <label class="col-md-1" for="rangoinicio12">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio12" name="rangoinicio12" value="<?php echo $objfechas->s12_rangoi; ?>" readonly>

                        <label for="rangofinal12" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal12" name="rangofinal12" value="<?php echo $objfechas->s12_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad12" name="TipoActividad12" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem12" name="DescripcionActSem12" placeholder="Descripcion" rows="6"><?php echo $objfechas->s12_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s12divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad12" name="TipoNovedad12" onfocus="showopt2s12();" onchange="showopt2s12();">
                            
                            <option value="<?php echo $objfechas->s12_tiponovedad; ?>" selected><?php if ($objfechas->s12_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s12_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s12_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s12_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s12_tiponovedad == " " or empty($objfechas->s12_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad12').value != " ") {
                        $("#TipoNovedad12").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s12divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem12" name="justificasem12" placeholder="Justificación" rows="2"><?php echo $objfechas->s12_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s12divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov12" name="fechanov12" value="<?php echo $objfechas->s12_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s12divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem12" name="justificarsem12" placeholder="Justificación" rows="2"><?php echo $objfechas->s12_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s12divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s12fecharep1" name="s12fecharep1" value="<?php echo $objfechas->s12_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s12divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s12fecharep2" name="s12fecharep2" value="<?php echo $objfechas->s12_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana13 -->
        <?php
        $fechai13 = strtotime($objfechas->s13_rangoi);
        $fechaf13 = date("d-m-Y", strtotime($objfechas->s13_rangof . "+ 1 days"));
        $fechaf13 = strtotime($fechaf13);

        if ($objfechas->s13_descripcion <> " " &&  $objfechas->s13_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem13" name="titulosem13" value="Semana 13" readonly>

                        <label class="col-md-1" for="rangoinicio13">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio13" name="rangoinicio13" value="<?php echo $objfechas->s13_rangoi; ?>" readonly>

                        <label for="rangofinal13" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal13" name="rangofinal13" value="<?php echo $objfechas->s13_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad13" name="TipoActividad13" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem13" name="DescripcionActSem13" placeholder="Descripcion" rows="6"><?php echo $objfechas->s13_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s13divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad13" name="TipoNovedad13" onfocus="showopt2s13();" onchange="showopt2s13();">
                            
                            <option value="<?php echo $objfechas->s13_tiponovedad; ?>" selected><?php if ($objfechas->s13_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s13_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s13_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s13_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s13_tiponovedad == " " or empty($objfechas->s13_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad13').value != " ") {
                        $("#TipoNovedad13").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s13divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem13" name="justificasem13" placeholder="Justificación" rows="2"><?php echo $objfechas->s13_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s13divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov13" name="fechanov13" value="<?php echo $objfechas->s13_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s13divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem13" name="justificarsem13" placeholder="Justificación" rows="2"><?php echo $objfechas->s13_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s13divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s13fecharep1" name="s13fecharep1" value="<?php echo $objfechas->s13_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s13divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s13fecharep2" name="s13fecharep2" value="<?php echo $objfechas->s13_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana14 -->
<?php
        $fechai14 = strtotime($objfechas->s14_rangoi);
        $fechaf14 = date("d-m-Y", strtotime($objfechas->s14_rangof . "+ 1 days"));
        $fechaf14 = strtotime($fechaf14);

        if ($objfechas->s14_descripcion <> " " &&  $objfechas->s14_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem14" name="titulosem14" value="Semana 14" readonly>

                        <label class="col-md-1" for="rangoinicio14">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio14" name="rangoinicio14" value="<?php echo $objfechas->s14_rangoi; ?>" readonly>

                        <label for="rangofinal14" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal14" name="rangofinal14" value="<?php echo $objfechas->s14_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad14" name="TipoActividad14" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem14" name="DescripcionActSem14" placeholder="Descripcion" rows="6"><?php echo $objfechas->s14_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s14divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad14" name="TipoNovedad14" onfocus="showopt2s14();" onchange="showopt2s14();">
                            
                            <option value="<?php echo $objfechas->s14_tiponovedad; ?>" selected><?php if ($objfechas->s14_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s14_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s14_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s14_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s14_tiponovedad == " " or empty($objfechas->s14_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad14').value != " ") {
                        $("#TipoNovedad14").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s14divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem14" name="justificasem14" placeholder="Justificación" rows="2"><?php echo $objfechas->s14_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s14divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov14" name="fechanov14" value="<?php echo $objfechas->s14_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s14divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem14" name="justificarsem14" placeholder="Justificación" rows="2"><?php echo $objfechas->s14_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s14divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s14fecharep1" name="s14fecharep1" value="<?php echo $objfechas->s14_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s14divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s14fecharep2" name="s14fecharep2" value="<?php echo $objfechas->s14_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana15 -->
        <!-- Semana15 -->
<?php
        $fechai15 = strtotime($objfechas->s15_rangoi);
        $fechaf15 = date("d-m-Y", strtotime($objfechas->s15_rangof . "+ 1 days"));
        $fechaf15 = strtotime($fechaf15);

        if ($objfechas->s15_descripcion <> " " &&  $objfechas->s15_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem15" name="titulosem15" value="Semana 15" readonly>

                        <label class="col-md-1" for="rangoinicio15">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio15" name="rangoinicio15" value="<?php echo $objfechas->s15_rangoi; ?>" readonly>

                        <label for="rangofinal15" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal15" name="rangofinal15" value="<?php echo $objfechas->s15_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad15" name="TipoActividad15" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem15" name="DescripcionActSem15" placeholder="Descripcion" rows="6"><?php echo $objfechas->s15_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s15divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad15" name="TipoNovedad15" onfocus="showopt2s15();" onchange="showopt2s15();">
                            
                            <option value="<?php echo $objfechas->s15_tiponovedad; ?>" selected><?php if ($objfechas->s15_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s15_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s15_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s15_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s15_tiponovedad == " " or empty($objfechas->s15_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad15').value != " ") {
                        $("#TipoNovedad15").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s15divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem15" name="justificasem15" placeholder="Justificación" rows="2"><?php echo $objfechas->s15_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s15divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov15" name="fechanov15" value="<?php echo $objfechas->s15_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s15divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem15" name="justificarsem15" placeholder="Justificación" rows="2"><?php echo $objfechas->s15_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s15divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s15fecharep1" name="s15fecharep1" value="<?php echo $objfechas->s15_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s15divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s15fecharep2" name="s15fecharep2" value="<?php echo $objfechas->s15_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana16 -->
        <!-- Semana16 -->
<?php
        $fechai16 = strtotime($objfechas->s16_rangoi);
        $fechaf16 = date("d-m-Y", strtotime($objfechas->s16_rangof . "+ 1 days"));
        $fechaf16 = strtotime($fechaf16);

        if ($objfechas->s16_descripcion <> " " &&  $objfechas->s16_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem16" name="titulosem16" value="Semana 16" readonly>

                        <label class="col-md-1" for="rangoinicio16">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio16" name="rangoinicio16" value="<?php echo $objfechas->s16_rangoi; ?>" readonly>

                        <label for="rangofinal16" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal16" name="rangofinal16" value="<?php echo $objfechas->s16_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad16" name="TipoActividad16" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem16" name="DescripcionActSem16" placeholder="Descripcion" rows="6"><?php echo $objfechas->s16_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s16divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad16" name="TipoNovedad16" onfocus="showopt2s16();" onchange="showopt2s16();">
                            
                            <option value="<?php echo $objfechas->s16_tiponovedad; ?>" selected><?php if ($objfechas->s16_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s16_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s16_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s16_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s16_tiponovedad == " " or empty($objfechas->s16_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad16').value != " ") {
                        $("#TipoNovedad16").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s16divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem16" name="justificasem16" placeholder="Justificación" rows="2"><?php echo $objfechas->s16_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s16divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov16" name="fechanov16" value="<?php echo $objfechas->s16_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s16divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem16" name="justificarsem16" placeholder="Justificación" rows="2"><?php echo $objfechas->s16_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s16divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s16fecharep1" name="s16fecharep1" value="<?php echo $objfechas->s16_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s16divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s16fecharep2" name="s16fecharep2" value="<?php echo $objfechas->s16_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Semana17 -->
        <?php
        $fechai17 = strtotime($objfechas->s17_rangoi);
        $fechaf17 = date("d-m-Y", strtotime($objfechas->s17_rangof . "+ 1 days"));
        $fechaf17 = strtotime($fechaf17);

        if ($objfechas->s17_descripcion <> " " &&  $objfechas->s17_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem17" name="titulosem17" value="Semana 17" readonly>

                        <label class="col-md-1" for="rangoinicio17">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio17" name="rangoinicio17" value="<?php echo $objfechas->s17_rangoi; ?>" readonly>

                        <label for="rangofinal17" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal17" name="rangofinal17" value="<?php echo $objfechas->s17_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad17" name="TipoActividad17" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem17" name="DescripcionActSem17" placeholder="Descripcion" rows="6"><?php echo $objfechas->s17_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s17divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad17" name="TipoNovedad17" onfocus="showopt2s17();" onchange="showopt2s17();">
                            
                            <option value="<?php echo $objfechas->s17_tiponovedad; ?>" selected><?php if ($objfechas->s17_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s17_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s17_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s17_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s17_tiponovedad == " " or empty($objfechas->s17_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad17').value != " ") {
                        $("#TipoNovedad17").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s17divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem17" name="justificasem17" placeholder="Justificación" rows="2"><?php echo $objfechas->s17_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s17divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov17" name="fechanov17" value="<?php echo $objfechas->s17_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s17divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem17" name="justificarsem17" placeholder="Justificación" rows="2"><?php echo $objfechas->s17_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s17divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s17fecharep1" name="s17fecharep1" value="<?php echo $objfechas->s17_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s17divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s17fecharep2" name="s17fecharep2" value="<?php echo $objfechas->s17_fechareprog2; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana18 -->
        <?php
        $fechai18 = strtotime($objfechas->s18_rangoi);
        $fechaf18 = date("d-m-Y", strtotime($objfechas->s18_rangof . "+ 1 days"));
        $fechaf18 = strtotime($fechaf18);

        if ($objfechas->s18_descripcion <> " " &&  $objfechas->s18_tipoactividad == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem18" name="titulosem18" value="Semana 18" readonly>

                        <label class="col-md-1" for="rangoinicio18">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio18" name="rangoinicio18" value="<?php echo $objfechas->s18_rangoi; ?>" readonly>

                        <label for="rangofinal18" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal18" name="rangofinal18" value="<?php echo $objfechas->s18_rangof; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad18" name="TipoActividad18" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem18" name="DescripcionActSem18" placeholder="Descripcion" rows="6"><?php echo $objfechas->s18_descripcion; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s18divopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad18" name="TipoNovedad18" onfocus="showopt2s18();" onchange="showopt2s18();">
                            
                            <option value="<?php echo $objfechas->s18_tiponovedad; ?>" selected><?php if ($objfechas->s18_tiponovedad == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s18_tiponovedad == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s18_tiponovedad == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s18_tiponovedad == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s18_tiponovedad == " " or empty($objfechas->s18_tiponovedad)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad18').value != " ") {
                        $("#TipoNovedad18").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s18divopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem18" name="justificasem18" placeholder="Justificación" rows="2"><?php echo $objfechas->s18_justifica_nov; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s18divopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov18" name="fechanov18" value="<?php echo $objfechas->s18_fechanovedad; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s18divopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem18" name="justificarsem18" placeholder="Justificación" rows="2"><?php echo $objfechas->s18_justifica_reprog; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s18divopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s18fecharep1" name="s18fecharep1" value="<?php echo $objfechas->s18_fechareprog1; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s18divopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s18fecharep2" name="s18fecharep2" value="<?php echo $objfechas->s18_fechareprog2; ?>">
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
        $fechai1p = strtotime($objfechas->s1_rangoi_p);
        $fechaf1p = date("d-m-Y", strtotime($objfechas->s1_rangof_p . "+ 1 days"));
        $fechaf1p = strtotime($fechaf1p);

        if ($objfechas->s1_descripcion_p <> " " &&  $objfechas->s1_tipoactividad_p == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem1p" name="titulosem1p" value="Semana 1" readonly>

                        <label class="col-md-1" for="rangoinicio1p">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio1p" name="rangoinicio1p" value="<?php echo $objfechas->s1_rangoi_p; ?>" readonly>

                        <label for="rangofinal1p" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal1p" name="rangofinal1p" value="<?php echo $objfechas->s1_rangof_p; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad1p" name="TipoActividad1p" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem1p" name="DescripcionActSem1p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s1_descripcion_p; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s1pdivopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad1p" name="TipoNovedad1p" onfocus="showopt2s1p();" onchange="showopt2s1p();">
                            
                            <option value="<?php echo $objfechas->s1_tiponovedad_p; ?>" selected><?php if ($objfechas->s1_tiponovedad_p == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s1_tiponovedad_p == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s1_tiponovedad_p == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s1_tiponovedad_p == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s1_tiponovedad_p == " " or empty($objfechas->s1_tiponovedad_p)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad1p').value != " ") {
                        $("#TipoNovedad1p").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s1pdivopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem1p" name="justificasem1p" placeholder="Justificación" rows="2"><?php echo $objfechas->s1_justifica_nov_p; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s1pdivopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov1p" name="fechanov1p" value="<?php echo $objfechas->s1_fechanovedad_p; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s1pdivopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem1p" name="justificarsem1p" placeholder="Justificación" rows="2"><?php echo $objfechas->s1_justifica_reprog_p; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s1pdivopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s1pfecharep1" name="s1pfecharep1" value="<?php echo $objfechas->s1_fechareprog1_p; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s1pdivopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s1pfecharep2" name="s1pfecharep2" value="<?php echo $objfechas->s1_fechareprog2_p; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana2p -->
        <?php
        $fechai2p = strtotime($objfechas->s2_rangoi_p);
        $fechaf2p = date("d-m-Y", strtotime($objfechas->s2_rangof_p . "+ 1 days"));
        $fechaf2p = strtotime($fechaf2p);

        if ($objfechas->s2_descripcion_p <> " " &&  $objfechas->s2_tipoactividad_p == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem2p" name="titulosem2p" value="Semana 2" readonly>

                        <label class="col-md-1" for="rangoinicio2p">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio2p" name="rangoinicio2p" value="<?php echo $objfechas->s2_rangoi_p; ?>" readonly>

                        <label for="rangofinal2p" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal2p" name="rangofinal2p" value="<?php echo $objfechas->s2_rangof_p; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad2p" name="TipoActividad2p" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem2p" name="DescripcionActSem2p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s2_descripcion_p; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s2pdivopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad2p" name="TipoNovedad2p" onfocus="showopt2s2p();" onchange="showopt2s2p();">
                            
                            <option value="<?php echo $objfechas->s2_tiponovedad_p; ?>" selected><?php if ($objfechas->s2_tiponovedad_p == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s2_tiponovedad_p == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s2_tiponovedad_p == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s2_tiponovedad_p == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s2_tiponovedad_p == " " or empty($objfechas->s2_tiponovedad_p)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad2p').value != " ") {
                        $("#TipoNovedad2p").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s2pdivopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem2p" name="justificasem2p" placeholder="Justificación" rows="2"><?php echo $objfechas->s2_justifica_nov_p; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s2pdivopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov2p" name="fechanov2p" value="<?php echo $objfechas->s2_fechanovedad_p; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s2pdivopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem2p" name="justificarsem2p" placeholder="Justificación" rows="2"><?php echo $objfechas->s2_justifica_reprog_p; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s2pdivopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s2pfecharep1" name="s2pfecharep1" value="<?php echo $objfechas->s2_fechareprog1_p; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s2pdivopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s2pfecharep2" name="s2pfecharep2" value="<?php echo $objfechas->s2_fechareprog2_p; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>

         <!-- Semana3p -->
        <?php
        $fechai3p = strtotime($objfechas->s3_rangoi_p);
        $fechaf3p = date("d-m-Y", strtotime($objfechas->s3_rangof_p . "+ 1 days"));
        $fechaf3p = strtotime($fechaf3p);

        if ($objfechas->s3_descripcion_p <> " " &&  $objfechas->s3_tipoactividad_p == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem3p" name="titulosem3p" value="Semana 3" readonly>

                        <label class="col-md-1" for="rangoinicio3p">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio3p" name="rangoinicio3p" value="<?php echo $objfechas->s3_rangoi_p; ?>" readonly>

                        <label for="rangofinal3p" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal3p" name="rangofinal3p" value="<?php echo $objfechas->s3_rangof_p; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad3p" name="TipoActividad3p" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem3p" name="DescripcionActSem3p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s3_descripcion_p; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s3pdivopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad3p" name="TipoNovedad3p" onfocus="showopt2s3p();" onchange="showopt2s3p();">
                            
                            <option value="<?php echo $objfechas->s3_tiponovedad_p; ?>" selected><?php if ($objfechas->s3_tiponovedad_p == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s3_tiponovedad_p == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s3_tiponovedad_p == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s3_tiponovedad_p == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s3_tiponovedad_p == " " or empty($objfechas->s3_tiponovedad_p)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad3p').value != " ") {
                        $("#TipoNovedad3p").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s3pdivopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem3p" name="justificasem3p" placeholder="Justificación" rows="2"><?php echo $objfechas->s3_justifica_nov_p; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s3pdivopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov3p" name="fechanov3p" value="<?php echo $objfechas->s3_fechanovedad_p; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s3pdivopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem3p" name="justificarsem3p" placeholder="Justificación" rows="2"><?php echo $objfechas->s3_justifica_reprog_p; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s3pdivopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3pfecharep1" name="s3pfecharep1" value="<?php echo $objfechas->s3_fechareprog1_p; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s3pdivopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3pfecharep2" name="s3pfecharep2" value="<?php echo $objfechas->s3_fechareprog2_p; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana4p -->
        <?php
        $fechai4p = strtotime($objfechas->s4_rangoi_p);
        $fechaf4p = date("d-m-Y", strtotime($objfechas->s4_rangof_p . "+ 1 days"));
        $fechaf4p = strtotime($fechaf4p);

        if ($objfechas->s4_descripcion_p <> " " &&  $objfechas->s4_tipoactividad_p == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
              
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem4p" name="titulosem4p" value="Semana 3" readonly>

                        <label class="col-md-1" for="rangoinicio4p">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio4p" name="rangoinicio4p" value="<?php echo $objfechas->s4_rangoi_p; ?>" readonly>

                        <label for="rangofinal4p" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal4p" name="rangofinal4p" value="<?php echo $objfechas->s4_rangof_p; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad4p" name="TipoActividad4p" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem4p" name="DescripcionActSem4p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s4_descripcion_p; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s4pdivopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad4p" name="TipoNovedad4p" onfocus="showopt2s4p();" onchange="showopt2s4p();">
                            
                            <option value="<?php echo $objfechas->s4_tiponovedad_p; ?>" selected><?php if ($objfechas->s4_tiponovedad_p == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s4_tiponovedad_p == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s4_tiponovedad_p == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s4_tiponovedad_p == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s4_tiponovedad_p == " " or empty($objfechas->s4_tiponovedad_p)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad4p').value != " ") {
                        $("#TipoNovedad4p").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s4pdivopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem4p" name="justificasem4p" placeholder="Justificación" rows="2"><?php echo $objfechas->s4_justifica_nov_p; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s4pdivopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov4p" name="fechanov4p" value="<?php echo $objfechas->s4_fechanovedad_p; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s4pdivopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem4p" name="justificarsem4p" placeholder="Justificación" rows="2"><?php echo $objfechas->s4_justifica_reprog_p; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s4pdivopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s4pfecharep1" name="s4pfecharep1" value="<?php echo $objfechas->s4_fechareprog1_p; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s4pdivopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s4pfecharep2" name="s4pfecharep2" value="<?php echo $objfechas->s4_fechareprog2_p; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>

         <!-- Semana5p -->
<?php
        $fechai5p = strtotime($objfechas->s5_rangoi_p);
        $fechaf5p = date("d-m-Y", strtotime($objfechas->s5_rangof_p . "+ 1 days"));
        $fechaf5p = strtotime($fechaf5p);

        if ($objfechas->s5_descripcion_p <> " " &&  $objfechas->s5_tipoactividad_p == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
              
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem5p" name="titulosem5p" value="Semana 3" readonly>

                        <label class="col-md-1" for="rangoinicio5p">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio5p" name="rangoinicio5p" value="<?php echo $objfechas->s5_rangoi_p; ?>" readonly>

                        <label for="rangofinal5p" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal5p" name="rangofinal5p" value="<?php echo $objfechas->s5_rangof_p; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad5p" name="TipoActividad5p" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem5p" name="DescripcionActSem5p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s5_descripcion_p; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s5pdivopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad5p" name="TipoNovedad5p" onfocus="showopt2s5p();" onchange="showopt2s5p();">
                            
                            <option value="<?php echo $objfechas->s5_tiponovedad_p; ?>" selected><?php if ($objfechas->s5_tiponovedad_p == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s5_tiponovedad_p == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s5_tiponovedad_p == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s5_tiponovedad_p == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s5_tiponovedad_p == " " or empty($objfechas->s5_tiponovedad_p)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad5p').value != " ") {
                        $("#TipoNovedad5p").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s5pdivopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem5p" name="justificasem5p" placeholder="Justificación" rows="2"><?php echo $objfechas->s5_justifica_nov_p; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s5pdivopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov5p" name="fechanov5p" value="<?php echo $objfechas->s5_fechanovedad_p; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s5pdivopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem5p" name="justificarsem5p" placeholder="Justificación" rows="2"><?php echo $objfechas->s5_justifica_reprog_p; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s5pdivopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s5pfecharep1" name="s5pfecharep1" value="<?php echo $objfechas->s5_fechareprog1_p; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s5pdivopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s5pfecharep2" name="s5pfecharep2" value="<?php echo $objfechas->s5_fechareprog2_p; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>

            <!--Hastaaqui -->
        <?php
    } ?>