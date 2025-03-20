<?php

//select de tabla temporal
include('conextemp.php');
include('conexion.php');

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
$resultado_qest8= pg_query($conexion2, $query_estrategia);


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


// select de tabla estrategia metodologica 17

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest17 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 17

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet17 = pg_query($conexion2, $query_metodo);

// select de tabla estrategia metodologica 18

$query_estrategia = "SELECT * FROM sistema.estrategias_met ORDER BY codigo_estrategia ASC ";
$resultado_qest18 = pg_query($conexion2, $query_estrategia);

// select de tabla metodologia evaluacion 18

$query_metodo = "SELECT * FROM sistema.met_evaluacion ORDER BY codigo_metodo ASC ";
$resultado_qmet18 = pg_query($conexion2, $query_metodo);


$query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
$resultado_temp = pg_query($conexion, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$value = strval($obj_temp->valor1);


session_start();
$tablam2=$_SESSION['tablam2'];

$codigoConsulta = $_SESSION['codigoConsulta'];;


// consulta tablam2
$query_consignac = "SELECT * FROM $tablam2 WHERE id= '$codigoConsulta'";
$resultado_qc = pg_query($conexion, $query_consignac);
$objConsultac = pg_fetch_object($resultado_qc);
?>

<?php

if ($value <> "26" && $value <> "30" && $value <> "31" && $value <> "32" ) { ?>

    <div class="container">

        <div class="row">
            <span class="badge text-bg-danger">
                <h5>Desarrollo</h5>
            </span>
        </div>

        <!-- // establecer fechas
        
        // $obj = pg_fetch_object($resultado_qper);
        // $fecha1 = $obj->fecha_inicio;
        // $fecha1 = date("d-m-Y", strtotime($obj->fecha_inicio));
        // $sem = $obj->total_semanas;
        // $semanas = 0;
        // while ($semanas <> $sem) {

        //     $fecha2 = date("d-m-Y", strtotime($fecha1 . "+5 days"));
            
        //     $rangoi[$semanas] = array("fecha" => $fecha1);
        //     $rangof[$semanas] = array("fecha" => $fecha2);
        //     $fechax = date("d-m-Y", strtotime($fecha1 . "+1 week"));
        //     $fecha1 = $fechax;
        //     $semanas = $semanas + 1;
        // }  -->
        
        <!-- semana 1 -->

        <div class="row">
            <div class="col-md-2 mt-2">
                <h6><span class="badge bg-danger">Semana</span></h6>
            </div>
            <div class="col-md-5 mt-2">
                <h6><span class="badge bg-danger">Contenidos</span></h6>
            </div>
            <div class="col-md-2 mt-2">
                <h6><span class="badge bg-danger">Estrategia Metodológica</span></h6>
            </div>
            <div class="col-md-3 mt-2">
                <h6><span class="badge bg-danger">Metodología de Evaluación</span></h6>
            </div>
        </div>
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem1" name="titulosem1" value="Semana 1" readonly>
                <label for="rangoinicio1">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio1" name="rangoinicio1" value="<?php echo $objConsultac->s1_rangoi; ?>" readonly>
                <label for="rangofinal1">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal1" name="rangofinal1" value="<?php echo $objConsultac->s1_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem1" name="ContenidoSem1" placeholder="Contenido" rows="6"><?php echo $objConsultac->s1_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia1" name="NombreEstrategia1">
                    <option value="<?php echo $objConsultac->s1_estrategia; ?>" selected><?php echo $objConsultac->s1_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest1)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo1" name="NombreMetodo1">
                    <option value="<?php echo $objConsultac->s1_metodologia; ?>" selected><?php echo $objConsultac->s1_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet1)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana2 -->
        <div class="row border border-danger rounded">
            <div class="col-sm-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem2" name="titulosem2" value="Semana 2" readonly>
                <label for="rangoinicio2">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio2" name="rangoinicio2" value="<?php echo $objConsultac->s2_rangoi; ?>" readonly>
                <label for="rangofinal2">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal2" name="rangofinal2" value="<?php echo $objConsultac->s2_rangof; ?>" readonly>
            </div>
            <div class="col-sm-5 mt-2">
                <textarea class="form-control" id="contenidoSem2" name="ContenidoSem2" placeholder="Contenido" rows="6"><?php echo $objConsultac->s2_contenidos; ?></textarea>
            </div>
            <div class="col-sm-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia2" name="NombreEstrategia2">
                    <option value="<?php echo $objConsultac->s2_estrategia; ?>" selected><?php echo $objConsultac->s2_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest2)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo2" name="NombreMetodo2">
                    <option value="<?php echo $objConsultac->s2_metodologia; ?>" selected><?php echo $objConsultac->s2_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet2)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana3 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem3" name="titulosem3" value="Semana 3" readonly>
                <label for="rangoinicio3">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio3" name="rangoinicio3" value="<?php echo $objConsultac->s3_rangoi; ?>" readonly>
                <label for="rangofinal3">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal3" name="rangofinal3" value="<?php echo $objConsultac->s3_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem3" name="ContenidoSem3" placeholder="Contenido" rows="6"><?php echo $objConsultac->s3_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia3" name="NombreEstrategia3">
                    <option value="<?php echo $objConsultac->s2_estrategia; ?>" selected><?php echo $objConsultac->s3_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest3)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo3" name="NombreMetodo3">
                    <option value="<?php echo $objConsultac->s3_metodologia; ?>" selected><?php echo $objConsultac->s3_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet3)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana4 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem4" name="titulosem4" value="Semana 4" readonly>
                <label for="rangoinicio4">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio4" name="rangoinicio4" value="<?php echo $objConsultac->s4_rangoi; ?>" readonly>
                <label for="rangofinal4">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal4" name="rangofinal4" value="<?php echo $objConsultac->s4_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem4" name="ContenidoSem4" placeholder="Contenido" rows="6"><?php echo $objConsultac->s4_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia4" name="NombreEstrategia4">
                    <option value="<?php echo $objConsultac->s4_estrategia; ?>" selected><?php echo $objConsultac->s4_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest4)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo4" name="NombreMetodo4">
                    <option value="<?php echo $objConsultac->s4_metodologia; ?>" selected><?php echo $objConsultac->s4_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet4)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana5 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem5" name="titulosem5" value="Semana 5" readonly>
                <label for="rangoinicio5">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio5" name="rangoinicio5" value="<?php echo $objConsultac->s5_rangoi; ?>" readonly>
                <label for="rangofinal5">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal5" name="rangofinal5" value="<?php echo $objConsultac->s5_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem5" name="ContenidoSem5" placeholder="Contenido" rows="6"><?php echo $objConsultac->s5_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia5" name="NombreEstrategia5">
                    <option value="<?php echo $objConsultac->s5_estrategia; ?>" selected><?php echo $objConsultac->s5_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest5)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo5" name="NombreMetodo5">
                    <option value="<?php echo $objConsultac->s5_metodologia; ?>" selected><?php echo $objConsultac->s5_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet5)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana6 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem6" name="titulosem6" value="Semana 6" readonly>
                <label for="rangoinicio6">Del:</label>                
                <input type="text" class="form-control form-control sm " id="rangoinicio6" name="rangoinicio6" value="<?php echo $objConsultac->s6_rangoi; ?>" readonly>
                <label for="rangofinal6">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal6" name="rangofinal6" value="<?php echo $objConsultac->s6_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem6" name="ContenidoSem6" placeholder="Contenido" rows="6"><?php echo $objConsultac->s6_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia6" name="NombreEstrategia6">
                    <option value="<?php echo $objConsultac->s6_estrategia; ?>" selected><?php echo $objConsultac->s6_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest6)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo6" name="NombreMetodo6">
                    <option value="<?php echo $objConsultac->s6_metodologia; ?>" selected><?php echo $objConsultac->s6_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet6)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana7 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem7" name="titulosem7" value="Semana 7" readonly>
                <label for="rangoinicio7">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio7" name="rangoinicio7" value="<?php echo $objConsultac->s7_rangoi; ?>" readonly>
                <label for="rangofinal7">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal7" name="rangofinal7" value="<?php echo $objConsultac->s7_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem7" name="ContenidoSem7" placeholder="Contenido" rows="6"><?php echo $objConsultac->s7_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia7" name="NombreEstrategia7">
                    <option value="<?php echo $objConsultac->s7_estrategia; ?>" selected><?php echo $objConsultac->s7_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest7)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo7" name="NombreMetodo7">
                    <option value="<?php echo $objConsultac->s7_metodologia; ?>" selected><?php echo $objConsultac->s7_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet7)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana8 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem8" name="titulosem8" value="Semana 8" readonly>
                <label for="rangoinicio8">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio8" name="rangoinicio8" value="<?php echo $objConsultac->s8_rangoi; ?>" readonly>
                <label for="rangofinal8">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal8" name="rangofinal8" value="<?php echo $objConsultac->s8_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem8" name="ContenidoSem8" placeholder="Contenido" rows="6"><?php echo $objConsultac->s8_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia8" name="NombreEstrategia8">
                    <option value="<?php echo $objConsultac->s8_estrategia; ?>" selected><?php echo $objConsultac->s8_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest8)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo8" name="NombreMetodo8">
                    <option value="<?php echo $objConsultac->s8_metodologia; ?>" selected><?php echo $objConsultac->s8_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet8)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana9 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem9" name="titulosem9" value="Semana 9" readonly>
                <label for="rangoinicio9">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio9" name="rangoinicio9" value="<?php echo $objConsultac->s9_rangoi; ?>" readonly>
                <label for="rangofinal9">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal9" name="rangofinal9" value="<?php echo $objConsultac->s9_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem9" name="ContenidoSem9" placeholder="Contenido" rows="6"><?php echo $objConsultac->s9_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia9" name="NombreEstrategia9">
                    <option value="<?php echo $objConsultac->s9_estrategia; ?>" selected><?php echo $objConsultac->s9_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest9)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo9" name="NombreMetodo9">
                    <option value="<?php echo $objConsultac->s9_metodologia; ?>" selected><?php echo $objConsultac->s9_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet9)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana10 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem10" name="titulosem10" value="Semana 10" readonly>
                <label for="rangoinicio10">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio10" name="rangoinicio10" value="<?php echo $objConsultac->s10_rangoi; ?>" readonly>
                <label for="rangofinal10">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal10" name="rangofinal10" value="<?php echo $objConsultac->s10_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem10" name="ContenidoSem10" placeholder="Contenido" rows="6"><?php echo $objConsultac->s10_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia10" name="NombreEstrategia10">
                    <option value="<?php echo $objConsultac->s10_estrategia; ?>" selected><?php echo $objConsultac->s10_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest10)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo10" name="NombreMetodo10">
                    <option value="<?php echo $objConsultac->s10_metodologia; ?>" selected><?php echo $objConsultac->s10_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet10)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana11 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem11" name="titulosem11" value="Semana 11" readonly>
                <label for="rangoinicio11">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio11" name="rangoinicio11" value="<?php echo $objConsultac->s11_rangoi; ?>" readonly>
                <label for="rangofinal11">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal11" name="rangofinal11" value="<?php echo $objConsultac->s11_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem11" name="ContenidoSem11" placeholder="Contenido" rows="6"><?php echo $objConsultac->s11_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia11" name="NombreEstrategia11">
                    <option value="<?php echo $objConsultac->s11_estrategia; ?>" selected><?php echo $objConsultac->s11_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest11)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo11" name="NombreMetodo11">
                    <option value="<?php echo $objConsultac->s11_metodologia; ?>" selected><?php echo $objConsultac->s11_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet11)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana12 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem12" name="titulosem12" value="Semana 12" readonly>
                <label for="rangoinicio12">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio12" name="rangoinicio12" value="<?php echo $objConsultac->s12_rangoi; ?>" readonly>
                <label for="rangofinal12">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal12" name="rangofinal12" value="<?php echo $objConsultac->s12_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem12" name="ContenidoSem12" placeholder="Contenido" rows="6"><?php echo $objConsultac->s12_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia12" name="NombreEstrategia12">
                    <option value="<?php echo $objConsultac->s12_estrategia; ?>" selected><?php echo $objConsultac->s12_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest12)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo12" name="NombreMetodo12">
                    <option value="<?php echo $objConsultac->s12_metodologia; ?>" selected><?php echo $objConsultac->s12_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet12)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana13 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem13" name="titulosem13" value="Semana 13" readonly>
                <label for="rangoinicio13">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio13" name="rangoinicio13" value="<?php echo $objConsultac->s13_rangoi; ?>" readonly>
                <label for="rangofinal13">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal13" name="rangofinal13" value="<?php echo $objConsultac->s13_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem13" name="ContenidoSem13" placeholder="Contenido" rows="6"><?php echo $objConsultac->s13_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia13" name="NombreEstrategia13">
                    <option value="<?php echo $objConsultac->s13_estrategia; ?>" selected><?php echo $objConsultac->s13_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest13)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo13" name="NombreMetodo13">
                    <option value="<?php echo $objConsultac->s13_metodologia; ?>" selected><?php echo $objConsultac->s13_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet13)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana14 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem14" name="titulosem14" value="Semana 14" readonly>
                <label for="rangoinicio14">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio14" name="rangoinicio14" value="<?php echo $objConsultac->s14_rangoi; ?>" readonly>
                <label for="rangofinal14">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal14" name="rangofinal14" value="<?php echo $objConsultac->s14_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem14" name="ContenidoSem14" placeholder="Contenido" rows="6"><?php echo $objConsultac->s14_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia14" name="NombreEstrategia14">
                    <option value="<?php echo $objConsultac->s14_estrategia; ?>" selected><?php echo $objConsultac->s14_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest14)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo14" name="NombreMetodo14">
                    <option value="<?php echo $objConsultac->s14_metodologia; ?>" selected><?php echo $objConsultac->s14_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet14)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana15 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem15" name="titulosem15" value="Semana 15" readonly>
                <label for="rangoinicio15">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio15" name="rangoinicio15" value="<?php echo $objConsultac->s15_rangoi; ?>" readonly>
                <label for="rangofinal15">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal15" name="rangofinal15" value="<?php echo $objConsultac->s15_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem15" name="ContenidoSem15" placeholder="Contenido" rows="6"><?php echo $objConsultac->s15_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia15" name="NombreEstrategia15">
                    <option value="<?php echo $objConsultac->s15_estrategia; ?>" selected><?php echo $objConsultac->s15_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest15)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo15" name="NombreMetodo15">
                    <option value="<?php echo $objConsultac->s15_metodologia; ?>" selected><?php echo $objConsultac->s15_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet15)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana16 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem16" name="titulosem16" value="Semana 16" readonly>
                <label for="rangoinicio16">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio16" name="rangoinicio16" value="<?php echo $objConsultac->s16_rangoi; ?>" readonly>
                <label for="rangofinal16">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal16" name="rangofinal16" value="<?php echo $objConsultac->s16_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem16" name="ContenidoSem16" placeholder="Contenido" rows="6"><?php echo $objConsultac->s16_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia16" name="NombreEstrategia16">
                    <option value="<?php echo $objConsultac->s16_estrategia; ?>" selected><?php echo $objConsultac->s16_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest16)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo16" name="NombreMetodo16">
                    <option value="<?php echo $objConsultac->s16_metodologia; ?>" selected><?php echo $objConsultac->s16_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet16)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana17 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem17" name="titulosem17" value="Semana 17" readonly>
                <label for="rangoinicio17">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio17" name="rangoinicio17" value="<?php echo $objConsultac->s17_rangoi; ?>" readonly>
                <label for="rangofinal17">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal17" name="rangofinal17" value="<?php echo $objConsultac->s17_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem17" name="ContenidoSem17" placeholder="Contenido" rows="6"><?php echo $objConsultac->s17_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia17" name="NombreEstrategia17">
                    <option value="<?php echo $objConsultac->s17_estrategia; ?>" selected><?php echo $objConsultac->s17_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest17)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo17" name="NombreMetodo17">
                    <option value="<?php echo $objConsultac->s17_metodologia; ?>" selected><?php echo $objConsultac->s17_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet17)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana18 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem18" name="titulosem18" value="Semana 18" readonly>
                <label for="rangoinicio18">Del:</label>
                <input type="text" class="form-control form-control sm " id="rangoinicio18" name="rangoinicio18" value="<?php echo $objConsultac->s18_rangoi; ?>" readonly>
                <label for="rangofinal18">Al:</label>
                <input type="text" class="form-control form-control sm " id="rangofinal18" name="rangofinal18" value="<?php echo $objConsultac->s18_rangof; ?>" readonly>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem18" name="ContenidoSem18" placeholder="Contenido" rows="6"><?php echo $objConsultac->s18_contenidos; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia18" name="NombreEstrategia18">
                    <option value="<?php echo $objConsultac->s18_estrategia; ?>" selected><?php echo $objConsultac->s18_estrategia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest18)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo18" name="NombreMetodo18">
                    <option value="<?php echo $objConsultac->s18_metodologia; ?>" selected><?php echo $objConsultac->s18_metodologia; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet18)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option> 
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
<?php
} else { ?>
    <div class="container">
        <div class="row">
            <span class="badge text-bg-danger">
                <h5>Desarrollo</h5>
            </span>
        </div>       
        <div class="row">
            <div class="col-md-2 mt-2">
                <h6><span class="badge bg-danger">Semana</span></h6>
            </div>
            <div class="col-md-5 mt-2">
                <h6><span class="badge bg-danger">Contenidos</span></h6>
            </div>
            <div class="col-md-2 mt-2">
                <h6><span class="badge bg-danger">Estrategia Metodológica</span></h6>
            </div>
            <div class="col-md-3 mt-2">
                <h6><span class="badge bg-danger">Metodología de Evaluación</span></h6>
            </div>
        </div>
        <!-- semana 1 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem1p" name="titulosem1p" value="Semana 1" readonly>
                <label for="frangoinicio1">Del:</label>
                <?php if ($objConsultac->s1_rangoi_p == " " || $objConsultac->s1_rangoi_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangoinicio1" name="frangoinicio1" >
                <?php }else{ ?>    
                  <input type="text" class="form-control form-control sm " id="frangoinicio1" name="frangoinicio1" value="<?php echo $objConsultac->s1_rangoi_p; ?>" readonly>
                <?php } ?>
                <label for="frangofinal1">Al:</label>
                <?php if ($objConsultac->s1_rangof_p == " " || $objConsultac->s1_rangof_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangofinal1" name="frangofinal1" >
                <?php }else{ ?>   
                  <input type="text" class="form-control form-control sm " id="frangofinal1" name="frangofinal1" value="<?php echo $objConsultac->s1_rangof_p; ?>" readonly>            
                <?php } ?>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem1p" name="ContenidoSem1p" placeholder="Contenido" rows="6"><?php echo $objConsultac->s1_contenidos_p; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia1p" name="NombreEstrategia1p">
                    <option value="<?php echo $objConsultac->s1_estrategia_p; ?>" selected><?php echo $objConsultac->s1_estrategia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest1p)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo1p" name="NombreMetodo1p">
                    <option value="<?php echo $objConsultac->s1_metodologia_p; ?>" selected><?php echo $objConsultac->s1_metodologia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet1p)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana2 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem2p" name="titulosem2p" value="Semana 2" readonly>
                <label for="frangoinicio2">Del:</label>
                <?php if ($objConsultac->s2_rangoi_p == " " || $objConsultac->s2_rangoi_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangoinicio2" name="frangoinicio2" >
                <?php }else{ ?>    
                <input type="text" class="form-control form-control sm " id="frangoinicio2" name="frangoinicio2" value="<?php echo $objConsultac->s2_rangoi_p; ?>" readonly>
                <?php } ?>
                <label for="frangofinal2">Al:</label>
                <?php if ($objConsultac->s2_rangof_p == " " || $objConsultac->s2_rangof_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangofinal2" name="frangofinal2" >
                <?php }else{ ?>
                <input type="text" class="form-control form-control sm " id="frangofinal2" name="frangofinal2" value="<?php echo $objConsultac->s2_rangof_p; ?>" readonly>            
                <?php } ?>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem2p" name="ContenidoSem2p" placeholder="Contenido" rows="6"><?php echo $objConsultac->s2_contenidos_p; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia2p" name="NombreEstrategia2p">
                    <option value="<?php echo $objConsultac->s2_estrategia_p; ?>" selected><?php echo $objConsultac->s2_estrategia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest2p)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo2p" name="NombreMetodo2p">
                    <option value="<?php echo $objConsultac->s2_metodologia_p; ?>" selected><?php echo $objConsultac->s2_metodologia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet2p)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana3 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem3p" name="titulosem3p" value="Semana 3" readonly>
                <label for="frangoinicio3">Del:</label>
                <?php if ($objConsultac->s3_rangoi_p == " " || $objConsultac->s3_rangoi_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangoinicio3" name="frangoinicio3" >
                <?php }else{ ?>   
                <input type="text" class="form-control form-control sm " id="frangoinicio3" name="frangoinicio3" value="<?php echo $objConsultac->s3_rangoi_p; ?>" readonly>
                <?php } ?>
                <label for="frangofinal3">Al:</label>
                <?php if ($objConsultac->s3_rangof_p == " " || $objConsultac->s3_rangof_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangofinal3" name="frangofinal3" >
                <?php }else{ ?>
                <input type="text" class="form-control form-control sm " id="frangofinal3" name="frangofinal3" value="<?php echo $objConsultac->s3_rangof_p; ?>" readonly>            
                <?php } ?>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem3p" name="ContenidoSem3p" placeholder="Contenido" rows="6"><?php echo $objConsultac->s3_contenidos_p; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia3p" name="NombreEstrategia3p">
                    <option value="<?php echo $objConsultac->s3_estrategia_p; ?>" selected><?php echo $objConsultac->s3_estrategia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest3p)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo3p" name="NombreMetodo3p">
                    <option value="<?php echo $objConsultac->s3_metodologia_p; ?>" selected><?php echo $objConsultac->s3_metodologia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet3p)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana4 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem4p" name="titulosem4p" value="Semana 4" readonly>
                <label for="frangoinicio4">Del:</label>
                <?php if ($objConsultac->s4_rangoi_p == " " || $objConsultac->s4_rangoi_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangoinicio4" name="frangoinicio4" >
                <?php }else{ ?>
                <input type="text" class="form-control form-control sm " id="frangoinicio4" name="frangoinicio4" value="<?php echo $objConsultac->s4_rangoi_p; ?>" readonly>
                <?php } ?>
                <label for="frangofinal4">Al:</label>
                <?php if ($objConsultac->s4_rangof_p == " " || $objConsultac->s4_rangof_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangofinal4" name="frangofinal4" >
                <?php }else{ ?>
                <input type="text" class="form-control form-control sm " id="frangofinal4" name="frangofinal4" value="<?php echo $objConsultac->s4_rangof_p; ?>" readonly>            
                <?php } ?>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem4p" name="ContenidoSem4p" placeholder="Contenido" rows="6"><?php echo $objConsultac->s4_contenidos_p; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia4p" name="NombreEstrategia4p">
                    <option value="<?php echo $objConsultac->s4_estrategia_p; ?>" selected><?php echo $objConsultac->s4_estrategia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest4p)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo4p" name="NombreMetodo4p">
                    <option value="<?php echo $objConsultac->s4_metodologia_p; ?>" selected><?php echo $objConsultac->s4_metodologia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet4p)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Semana5 -->
        <div class="row border border-danger rounded">
            <div class="col-md-2 mt-2">
                <input type="text" class="form-control form-control sm inputClass" id="titulosem5p" name="titulosem5p" value="Semana 5" readonly>
                <label for="frangoinicio5">Del:</label>
                <?php if ($objConsultac->s5_rangoi_p == " " || $objConsultac->s5_rangoi_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangoinicio5" name="frangoinicio5" >
                <?php }else{ ?>
                <input type="text" class="form-control form-control sm " id="frangoinicio5" name="frangoinicio5" value="<?php echo $objConsultac->s5_rangoi_p; ?>" readonly>
                <?php } ?>
                <label for="frangofinal5">Al:</label>
                <?php if ($objConsultac->s5_rangof_p == " " || $objConsultac->s5_rangof_p ==null ) { ?>
                    <input type="date" class="form-control form-control sm" id="frangofinal5" name="frangofinal5" >
                <?php }else{ ?>
                <input type="text" class="form-control form-control sm " id="frangofinal5" name="frangofinal5" value="<?php echo $objConsultac->s5_rangof_p; ?>" readonly>            
                <?php } ?>
            </div>
            <div class="col-md-5 mt-2">
                <textarea class="form-control" id="contenidoSem5p" name="ContenidoSem5p" placeholder="Contenido" rows="6"><?php echo $objConsultac->s5_contenidos_p; ?></textarea>
            </div>
            <div class="col-md-2 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreEstrategia5p" name="NombreEstrategia5p">
                    <option value="<?php echo $objConsultac->s5_estrategia_p; ?>" selected><?php echo $objConsultac->s5_estrategia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qest5p)) { ?>
                        <option value="<?php echo $obj->nombre_estrategia; ?>"><?php echo $obj->nombre_estrategia; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="NombreMetodo5p" name="NombreMetodo5p">
                    <option value="<?php echo $objConsultac->s5_metodologia_p; ?>" selected><?php echo $objConsultac->s5_metodologia_p; ?></option>
                    <?php
                    while ($obj = pg_fetch_object($resultado_qmet5p)) { ?>
                        <option value="<?php echo $obj->nombre_metodo; ?>"><?php echo $obj->nombre_metodo; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <?php
} ?>