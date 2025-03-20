<?php

date_default_timezone_set("America/Bogota");
session_start();
include('conextemp.php');

//temporal

// $query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
// $resultado_temp = pg_query($conexion2, $query_temp);
// $obj_temp = pg_fetch_object($resultado_temp);
// $codigoConsulta = $obj_temp->valor2;

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
        <?php
        $fechai1 = strtotime($objfechas->s1_rangoi);
        $fechaf1 = date("d-m-Y", strtotime($objfechas->s1_rangof . "+ 1 days"));
        $fechaf1 = strtotime($fechaf1);

        //if ($fechahoy >= $fechai1 &&  $fechahoy <= $fechaf1) { 
        if ($objfechas->s1_descripcion<>" "  &&  $objfechas->s1_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad1" name="TipoActividad1" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem1" name="DescripcionActSem1" placeholder="Descripcion" rows="6"><?php echo $objfechas->s1_descripcion; ?></textarea>
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

        //if ($fechahoy >= $fechai2 &&  $fechahoy <= $fechaf2) { 
        if ($objfechas->s2_descripcion<>" "  &&  $objfechas->s2_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad2" name="TipoActividad2" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem2" name="DescripcionActSem2" placeholder="Descripcion" rows="6"><?php echo $objfechas->s2_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana3 -->
        <?php
        $fechai3 = strtotime($objfechas->s3_rangoi);
        $fechaf3 = date("d-m-Y", strtotime($objfechas->s3_rangof . "+ 1 days"));
        $fechaf3 = strtotime($fechaf3);

        //if ($fechahoy >= $fechai3 &&  $fechahoy <= $fechaf3) { 
        if ($objfechas->s3_descripcion<>" "  &&  $objfechas->s3_tipoactividad=="Regular") { ?>    
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad3" name="TipoActividad3" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem3" name="DescripcionActSem3" placeholder="Descripcion" rows="6"><?php echo $objfechas->s3_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana4 -->
        <?php
        $fechai4 = strtotime($objfechas->s4_rangoi);
        $fechaf4 = date("d-m-Y", strtotime($objfechas->s4_rangof . "+ 1 days"));
        $fechaf4 = strtotime($fechaf4);

        //if ($fechahoy >= $fechai4 &&  $fechahoy <= $fechaf4) { 
        if ($objfechas->s4_descripcion<>" "  &&  $objfechas->s4_tipoactividad=="Regular") { ?>
            <div class="row border border-danger rounded">
                <div class="col-md-8 mt-2">
                    <input type="text" class="inputClass col-md-2" id="titulosem4" name="titulosem4" value="Semana 4" readonly>

                    <label class="col-md-1" for="rangoinicio4">Del:</label>
                    <input type="text" class="col-md-2" id="rangoinicio4" name="rangoinicio4" value="<?php echo $objfechas->s4_rangoi; ?>" readonly>

                    <label for="rangofinal4" class="col-md-1">Al:</label>
                    <input type="text" class="col-md-2" id="rangofinal4" name="rangofinal4" value="<?php echo $objfechas->s4_rangof; ?>" readonly>
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" class="form-control form-control sm" id="TipoActividad4" name="TipoActividad4" value="Regular" readonly>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem4" name="DescripcionActSem4" placeholder="Descripcion" rows="6"><?php echo $objfechas->s4_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana5 -->
        <?php
        $fechai5 = strtotime($objfechas->s5_rangoi);
        $fechaf5 = date("d-m-Y", strtotime($objfechas->s5_rangof . "+ 1 days"));
        $fechaf5 = strtotime($fechaf5);

        //if ($fechahoy >= $fechai5 &&  $fechahoy <= $fechaf5) { 
        if ($objfechas->s5_descripcion<>" "  &&  $objfechas->s5_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad5" name="TipoActividad5" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem5" name="DescripcionActSem5" placeholder="Descripcion" rows="6"><?php echo $objfechas->s5_descripcion; ?></textarea>
                    </div>
                </div>

            </div>
        <?php } ?>
        <!-- Semana6 -->
        <?php
        $fechai6 = strtotime($objfechas->s6_rangoi);
        $fechaf6 = date("d-m-Y", strtotime($objfechas->s6_rangof . "+ 1 days"));
        $fechaf6 = strtotime($fechaf6);

        //if ($fechahoy >= $fechai6 &&  $fechahoy <= $fechaf6) { 
        if ($objfechas->s6_descripcion<>" "  &&  $objfechas->s6_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad6" name="TipoActividad6" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem6" name="DescripcionActSem6" placeholder="Descripcion" rows="6"><?php echo $objfechas->s6_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana7 -->
        <?php
        $fechai7 = strtotime($objfechas->s7_rangoi);
        $fechaf7 = date("d-m-Y", strtotime($objfechas->s7_rangof . "+ 1 days"));
        $fechaf7 = strtotime($fechaf7);

        //if ($fechahoy >= $fechai7 &&  $fechahoy <= $fechaf7) { 
        if ($objfechas->s7_descripcion<>" "  &&  $objfechas->s7_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad7" name="TipoActividad7" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem7" name="DescripcionActSem7" placeholder="Descripcion" rows="6"><?php echo $objfechas->s7_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana8 -->
        <?php
        $fechai8 = strtotime($objfechas->s8_rangoi);
        $fechaf8 = date("d-m-Y", strtotime($objfechas->s8_rangof . "+ 1 days"));
        $fechaf8 = strtotime($fechaf8);

        //if ($fechahoy >= $fechai8 &&  $fechahoy <= $fechaf8) { 
        if ($objfechas->s8_descripcion<>" "  &&  $objfechas->s8_tipoactividad=="Regular") { ?>    
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad8" name="TipoActividad8" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem8" name="DescripcionActSem8" placeholder="Descripcion" rows="6"><?php echo $objfechas->s8_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana9 -->
        <?php
        $fechai9 = strtotime($objfechas->s9_rangoi);
        $fechaf9 = date("d-m-Y", strtotime($objfechas->s9_rangof . "+ 1 days"));
        $fechaf9 = strtotime($fechaf9);

        //if ($fechahoy >= $fechai9 &&  $fechahoy <= $fechaf9) { 
        if ($objfechas->s9_descripcion<>" "  &&  $objfechas->s9_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad9" name="TipoActividad9" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem9" name="DescripcionActSem9" placeholder="Descripcion" rows="6"><?php echo $objfechas->s9_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana10 -->
        <?php
        $fechai10 = strtotime($objfechas->s10_rangoi);
        $fechaf10 = date("d-m-Y", strtotime($objfechas->s10_rangof . "+ 1 days"));
        $fechaf10 = strtotime($fechaf10);

        //if ($fechahoy >= $fechai10 &&  $fechahoy <= $fechaf10) { 
        if ($objfechas->s10_descripcion<>" "  &&  $objfechas->s10_tipoactividad=="Regular") { ?>  
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad10" name="TipoActividad10" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem10" name="DescripcionActSem10" placeholder="Descripcion" rows="6"><?php echo $objfechas->s10_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana11 -->
        <?php
        $fechai11 = strtotime($objfechas->s11_rangoi);
        $fechaf11 = date("d-m-Y", strtotime($objfechas->s11_rangof . "+ 1 days"));
        $fechaf11 = strtotime($fechaf11);

        //if ($fechahoy >= $fechai11 &&  $fechahoy <= $fechaf11) { 
        if ($objfechas->s11_descripcion<>" "  &&  $objfechas->s11_tipoactividad=="Regular") { ?> 
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad11" name="TipoActividad11" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem11" name="DescripcionActSem11" placeholder="Descripcion" rows="6"><?php echo $objfechas->s11_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana12 -->
        <?php
        $fechai12 = strtotime($objfechas->s12_rangoi);
        $fechaf12 = date("d-m-Y", strtotime($objfechas->s12_rangof . "+ 1 days"));
        $fechaf12 = strtotime($fechaf12);

        //if ($fechahoy >= $fechai12 &&  $fechahoy <= $fechaf12) {
        if ($objfechas->s12_descripcion<>" "  &&  $objfechas->s12_tipoactividad=="Regular") { ?> 
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad12" name="TipoActividad12" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem12" name="DescripcionActSem12" placeholder="Descripcion" rows="6"><?php echo $objfechas->s12_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana13 -->
        <?php
        $fechai13 = strtotime($objfechas->s13_rangoi);
        $fechaf13 = date("d-m-Y", strtotime($objfechas->s13_rangof . "+ 1 days"));
        $fechaf13 = strtotime($fechaf13);

        //if ($fechahoy >= $fechai13 &&  $fechahoy <= $fechaf13) { 
        if ($objfechas->s13_descripcion<>" "  &&  $objfechas->s13_tipoactividad=="Regular") { ?> 
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad13" name="TipoActividad13" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem13" name="DescripcionActSem13" placeholder="Descripcion" rows="6"><?php echo $objfechas->s13_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana14 -->
        <?php
        $fechai14 = strtotime($objfechas->s14_rangoi);
        $fechaf14 = date("d-m-Y", strtotime($objfechas->s14_rangof . "+ 1 days"));
        $fechaf14 = strtotime($fechaf14);

        //if ($fechahoy >= $fechai14 &&  $fechahoy <= $fechaf14) { 
        if ($objfechas->s14_descripcion<>" "  &&  $objfechas->s14_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad14" name="TipoActividad14" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem14" name="DescripcionActSem14" placeholder="Descripcion" rows="6"><?php echo $objfechas->s14_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana15 -->
        <?php
        $fechai15 = strtotime($objfechas->s15_rangoi);
        $fechaf15 = date("d-m-Y", strtotime($objfechas->s15_rangof . "+ 1 days"));
        $fechaf15 = strtotime($fechaf15);

        //if ($fechahoy >= $fechai15 &&  $fechahoy <= $fechaf15) { 
        if ($objfechas->s15_descripcion<>" "  &&  $objfechas->s15_tipoactividad=="Regular") { ?>
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad15" name="TipoActividad15" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem15" name="DescripcionActSem15" placeholder="Descripcion" rows="6"><?php echo $objfechas->s15_descripcion; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Semana16 -->
        <?php
        $fechai16 = strtotime($objfechas->s16_rangoi);
        $fechaf16 = date("d-m-Y", strtotime($objfechas->s16_rangof . "+ 1 days"));
        $fechaf16 = strtotime($fechaf16);

        //if ($fechahoy >= $fechai16 &&  $fechahoy <= $fechaf16) { 
        if ($objfechas->s16_descripcion<>" "  &&  $objfechas->s16_tipoactividad=="Regular") { ?>    
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad16" name="TipoActividad16" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem16" name="DescripcionActSem16" placeholder="Descripcion" rows="6"><?php echo $objfechas->s16_rangof; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        
        <!-- Semana17 -->
        <?php
        $fechai17 = strtotime($objfechas->s17_rangoi);
        $fechaf17 = date("d-m-Y", strtotime($objfechas->s17_rangof . "+ 1 days"));
        $fechaf17 = strtotime($fechaf17);
 
        if ($objfechas->s17_descripcion<>" "  &&  $objfechas->s17_tipoactividad=="Regular") { ?>    
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad17" name="TipoActividad17" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem17" name="DescripcionActSem17" placeholder="Descripcion" rows="6"><?php echo $objfechas->s17_rangof; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
        
        
        <!-- Semana18 -->
        <?php
        $fechai18 = strtotime($objfechas->s18_rangoi);
        $fechaf18 = date("d-m-Y", strtotime($objfechas->s18_rangof . "+ 1 days"));
        $fechaf18 = strtotime($fechaf18);
 
        if ($objfechas->s18_descripcion<>" "  &&  $objfechas->s18_tipoactividad=="Regular") { ?>    
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
                        <input type="text" class="form-control form-control sm" id="TipoActividad18" name="TipoActividad18" value="Regular" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem18" name="DescripcionActSem18" placeholder="Descripcion" rows="6"><?php echo $objfechas->s18_rangof; ?></textarea>
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

            //if ((!empty($objfechas->s1_rangoi_p)) && (!empty($objfechas->s1_rangof_p))) {
                //if ($fechahoy >= $fechai1p &&  $fechahoy <= $fechaf1p) { 
                if ($objfechas->s1_descripcion_p<>" "  &&  $objfechas->s1_tipoactividad_p=="Regular") { ?>
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
                                <input type="text" class="form-control form-control sm" id="TipoActividad1p" name="TipoActividad1p" value="Regular" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h6><span class="badge bg-danger">Descripción</span></h6>
                                <textarea class="form-control" id="DescripcionActSem1p" name="DescripcionActSem1p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s1_descripcion_p; ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            
            <!-- Semana2 -->

            <?php
            $fechai2p = strtotime($objfechas->s2_rangoi_p);
            $fechaf2p = date("d-m-Y", strtotime($objfechas->s2_rangof_p . "+ 1 days"));
            $fechaf2p = strtotime($fechaf2p);

            //if ((!empty($objfechas->s2_rangoi_p)) && (!empty($objfechas->s2_rangof_p))) {
                //if ($fechahoy >= $fechai2p &&  $fechahoy <= $fechaf2p) { 
                if ($objfechas->s2_descripcion_p<>" "  &&  $objfechas->s2_tipoactividad_p=="Regular") { ?>
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
                                <input type="text" class="form-control form-control sm" id="TipoActividad2p" name="TipoActividad2p" value="Regular" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h6><span class="badge bg-danger">Descripción</span></h6>
                                <textarea class="form-control" id="DescripcionActSem2p" name="DescripcionActSem2p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s2_descripcion_p; ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            
            <!-- Semana3 -->

            <?php
            $fechai3p = strtotime($objfechas->s3_rangoi_p);
            $fechaf3p = date("d-m-Y", strtotime($objfechas->s3_rangof_p . "+ 1 days"));
            $fechaf3p = strtotime($fechaf3p);
        
            //if ((!empty($objfechas->s3_rangoi_p)) && (!empty($objfechas->s3_rangof_p))) {
                //if ($fechahoy >= $fechai3p &&  $fechahoy <= $fechaf3p) { 
                if ($objfechas->s3_descripcion_p<>" "  &&  $objfechas->s3_tipoactividad_p=="Regular") { ?>    
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
                                <input type="text" class="form-control form-control sm" id="TipoActividad3p" name="TipoActividad3p" value="Regular" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h6><span class="badge bg-danger">Descripción</span></h6>
                                <textarea class="form-control" id="DescripcionActSem3p" name="DescripcionActSem3p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s3_descripcion_p; ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            
            <!-- Semana4 -->
            <?php
            $fechai4p = strtotime($objfechas->s4_rangoi_p);
            $fechaf4p = date("d-m-Y", strtotime($objfechas->s4_rangof_p . "+ 1 days"));
            $fechaf4p = strtotime($fechaf4p);

            //if ((!empty($objfechas->s4_rangoi_p)) && (!empty($objfechas->s4_rangof_p))) {
                //if ($fechahoy >= $fechai4p &&  $fechahoy <= $fechaf4p) { 
                if ($objfechas->s4_descripcion_p<>" "  &&  $objfechas->s4_tipoactividad_p=="Regular") { ?>    
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
                                <input type="text" class="form-control form-control sm" id="TipoActividad4p" name="TipoActividad4p" value="Regular" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h6><span class="badge bg-danger">Descripción</span></h6>
                                <textarea class="form-control" id="DescripcionActSem4p" name="DescripcionActSem4p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s4_descripcion_p; ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            
            <!-- Semana5 -->
            <?php
            $fechai5p = strtotime($objfechas->s5_rangoi_p);
            $fechaf5p = date("d-m-Y", strtotime($objfechas->s5_rangof_p . "+ 1 days"));
            $fechaf5p = strtotime($fechaf5p);

            //if ((!empty($objfechas->s5_rangoi_p)) && (!empty($objfechas->s5_rangof_p))) {
                //if ($fechahoy >= $fechai5p &&  $fechahoy <= $fechaf5p) { 
                if ($objfechas->s5_descripcion_p<>" "  &&  $objfechas->s5_tipoactividad_p=="Regular") { ?> 
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
                                <input type="text" class="form-control form-control sm" id="TipoActividad5p" name="TipoActividad5p" value="Regular" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h6><span class="badge bg-danger">Descripción</span></h6>
                                <textarea class="form-control" id="DescripcionActSem5p" name="DescripcionActSem5p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s5_descripcion_p; ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            
            <!--Hastaaqui -->
        <?php
    } ?>