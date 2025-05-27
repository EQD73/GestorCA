<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$codperiodo = $_SESSION['codigo_periodo'];
$anio = $_SESSION['anio'];


include('conexion.php');


//select de tabla facultades

$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);

// select de tabla asignaturas
$codigousuario = $_SESSION['codigo_usuario'];
$query_carga = "SELECT
	dap.*,
	p.nombre_programa, 
	u.nomcompleto,
	p.codigo_facultad,
	f.nombre_facultad,
    a.nom_asignatura,
    a.creditos
FROM
	sistema.docente_asignaturas_periodo dap 
INNER JOIN sistema.programas p  ON dap.codigo_programa = p.codigo_programa
INNER JOIN sistema.asignaturas a  ON dap.codigo_asignatura = a.codigo_asignatura
INNER JOIN sistema.usuarios u  ON dap.codigo_docente = u.codigo_usuario::varchar
INNER JOIN sistema.facultades f  ON p.codigo_facultad = f.codigo_facultad
WHERE dap.codigo_docente='$codigousuario' AND codigo_periodo='$codperiodo'";
// $query_carga = "SELECT * FROM sistema.docente_asignaturas_periodo WHERE codigo_docente='$codigousuario' ORDER BY codigo_asignatura ASC, grupo ASC ";
$resultado_qa = pg_query($conexion, $query_carga);
$num2 = pg_num_rows($resultado_qa);

// select de tabla asignaturas

$query_asignaturas2 = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC";
$resultado_qa2 = pg_query($conexion, $query_asignaturas2);
$num2 = pg_num_rows($resultado_qa2);

// select de tabla programas

$query_programas = "SELECT * FROM sistema.programas ORDER BY codigo_programa ASC ";
$resultado_qp = pg_query($conexion, $query_programas);
$num3 = pg_num_rows($resultado_qp);

// select de tabla evaluacion

$query_evaluacion = "SELECT * FROM sistema.evaluacion ORDER BY id ASC ";
$resultado_qe = pg_query($conexion, $query_evaluacion);
$num4 = pg_num_rows($resultado_qe);

// select de tabla nivel
$query_nivel = "SELECT * FROM sistema.nivel ORDER BY id ASC ";
$resultado_qn = pg_query($conexion, $query_nivel);
$num5 = pg_num_rows($resultado_qn);

///*****querys usuarios */
$query_usuarios1 = "SELECT * FROM sistema.usuarios WHERE codigo_rol='2' ORDER BY codigo_usuario ASC ";
$resultado_qu = pg_query($conexion, $query_usuarios1);

//select de tabla de usuarios 

$query_usuarios2 = "SELECT * FROM sistema.usuarios WHERE codigo_rol='4' ORDER BY codigo_usuario ASC ";
$resultado_qu2 = pg_query($conexion, $query_usuarios2);

//select de tabla de usuarios 

$query_usuarios3 = "SELECT * FROM sistema.usuarios WHERE codigo_rol='5' ORDER BY codigo_usuario ASC ";
$resultado_qu3 = pg_query($conexion, $query_usuarios3);




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>



    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/css/BsMultiSelect.min.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> -->

</head>

<!-- <style type="text/css">
    #requisitos{
        width: 65em;
    }
    
</style> -->
<?php
$estadoper = $_SESSION['estado_periodo'];
if ($estadoper == 'BLOQUEADO') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                icon: "info",
                title: "Cuidado!",
                text: "Usted no puede ingresar Nuevo Microcurriculo en un periodo Cerrado o Bloqueado. Solo Consultar",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {
                if (result.value) {
                    window.location.href = "Microcurriculo.php";

                }
            });
        });
    </script>
<?php
} else {
?>

    <style type="text/css">
        /* .inputClass {
            font-weight: bold;
        } */

        .disabled {
            pointer-events: none;
            opacity: 0.7;
            border-color: rgba(118, 118, 118, 0.3);
            color: -internal-light-dark(graytext, rgb(170, 170, 170));
        }
    </style>
    <style>
        /* Cambiar el color de la pestaña activa (cuando está seleccionada) */
        .nav-pills .nav-link.active {
            background-color: red !important;
            color: white !important;
        }

        /* Cambiar el color del texto de las pestañas inactivas */
        .nav-pills .nav-link {
            color: red !important;
        }

        /* Opcional: cambiar color al pasar el cursor */
        .nav-pills .nav-link:hover {
            color: darkred !important;
        }
    </style>

    <body>

        <div id="app">
            <?php include("cargue_menul.html"); ?>
            <div id="main">
                <nav class="navbar navbar-header navbar-expand navbar-light">
                    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                            <li class="dropdown nav-icon">
                                <a href="#" data-bs-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-lg-inline-block">
                                        <i data-feather="bell"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                    <h6 class='py-2 px-4'>Notificaciones</h6>
                                    <ul class="list-group rounded-none">
                                        <li class="list-group-item border-0 align-items-start">
                                            <div class="avatar bg-success me-3">
                                                <span class="avatar-content"><i data-feather="alert-circle"></i></span>
                                            </div>
                                            <div>
                                                <h6 class='text-bold'>Aviso</h6>
                                                <p class='text-xs'>
                                                    No hay información
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="avatar me-1">
                                        <img src="../assets/images/avatar/avatarX.png" alt="" srcset="">
                                    </div>
                                    <div class="d-none d-md-block d-lg-inline-block">Hola, <?php echo $nombre; ?></div><br>
                                    <div class="d-none d-md-block d-lg-inline-block"><?php echo $_SESSION['nombre_rol']; ?></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#"><i data-feather="user"></i> Cuenta/Perfil</a>
                                    <!-- <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a> -->
                                    <!-- <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i>Salir</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="main-content container-fluid">
                    <div class="row">
                        <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Periodo Académico: <?php echo $_SESSION['descripcion']; ?></h4>

                    </div>
                    <div class="container p-3">
                        <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo MicroCurriculo - Agregar registro</h4>
                        <hr>
                    </div>

                    <!-- //inicio de nav-tab  -->

                    <ul class="nav nav-pills sm-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Identificación</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Metodología</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Unidad 1</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">Unidad 2</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button" role="tab" aria-controls="pills-5" aria-selected="false">Unidad 3</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-6-tab" data-bs-toggle="pill" data-bs-target="#pills-6" type="button" role="tab" aria-controls="pills-6" aria-selected="false">Unidad 4</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-7-tab" data-bs-toggle="pill" data-bs-target="#pills-7" type="button" role="tab" aria-controls="pills-7" aria-selected="false">Unidad 5</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-8-tab" data-bs-toggle="pill" data-bs-target="#pills-8" type="button" role="tab" aria-controls="pills-8" aria-selected="false">Proy. Integrador</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-9-tab" data-bs-toggle="pill" data-bs-target="#pills-9" type="button" role="tab" aria-controls="pills-9" aria-selected="false">Validación</button>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <?php include('FormMicro.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2024 &copy; UniCorsalud </p>
                </div>
                <!--  <div class="float-end">
                        <p>Crafted with <span class='text-danger'><i data-feather=""></i></span> by <a href="#">Eqd</a></p>
                    </div> -->
            </div>
        </footer>
        </div>
        </div>
    <?php
}
    ?>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- <script src="../assets/js/app.js"></script> -->
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script> -->
    <!-- <script type="text/javascript" src="dist/js/virtual-select.min.js"></script> -->
    <!-- Scripts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




    <!--<script type="text/javascript">
        VirtualSelect.init({ 
        ele: '#requisitos',
        multiple: true 
        });
    </script> -->


    <script type="text/javascript">
        document.getElementById('CodigoCurso').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada */
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input */
            var elCode = document.getElementById('CodigoCur');
            var elName = document.getElementById('NombreCurso');
            var elGroup = document.getElementById('grupo');
            var elcodf = document.getElementById('CodigoFacultad');
            var elcodf2 = document.getElementById('CodFacul');
            var elnomf = document.getElementById('NombreFacul');
            var elSem = document.getElementById('semestre');
            var elcodp = document.getElementById('CodigoPrograma');
            var elcodp2 = document.getElementById('CodProg');
            var elnomp = document.getElementById('NombreProg');
            var elcred = document.getElementById('creditos');
            var elnomdoc = document.getElementById('NomDocente');
            var elcodper = document.getElementById('Codper');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            elName.value = mData.nombre;
            elGroup.value = mData.grupo;
            elcodf.value = mData.codfacul;
            elcodf2.value = mData.codfacul;
            elnomf.value = mData.nomfacul;
            elSem.value = mData.semestre;
            elcodp.value = mData.codprog;
            elcodp2.value = mData.codprog;
            elnomp.value = mData.nomprog;
            elcred.value = mData.cred;
            elnomdoc.value = mData.nomdocente;
            elcodper.value = mData.codper;


            var codigocurso = document.getElementById('CodigoCur').value;

            $.ajax({
                url: "EnviarCurso.php",
                type: "GET",
                data: {
                    codigocurso: codigocurso
                },
                success: function(response) {
                    console.log("Respuesta del backend:", response);

                    const prerequisitos = response?.data?.prerequisitos;

                    const $prerequisitoSelect = $('#requisitos');

                    if ($prerequisitoSelect.hasClass('select2-hidden-accessible')) {
                        $prerequisitoSelect.select2('destroy');
                    }

                    $prerequisitoSelect.empty().prop('disabled', false);

                    $prerequisitoSelect.select2({
                        theme: 'bootstrap-5',
                        placeholder: 'No hay prerrequisitos definidos',
                        allowClear: false,
                        width: '100%',
                        closeOnSelect: false,
                        templateSelection: function(data) {
                            var color = obtenerColorPorCodigo(data.id);
                            return $('<span>')
                                .text(data.text)
                                .css('background-color', color)
                                .css('color', 'black')
                                .css('padding', '2px 8px')
                                .css('border-radius', '10px')
                                .css('margin-right', '4px');
                        }
                    });

                    if (Array.isArray(prerequisitos) && prerequisitos.length > 0) {
                        const prereqCodes = [];

                        prerequisitos.forEach(item => {
                            const codigo = item.codigo_prerequisito;
                            const nombre = item.nombre_prerequisito;

                            if (codigo && nombre) {
                                const option = new Option(`${codigo} - ${nombre}`, codigo, false, false);
                                $prerequisitoSelect.append(option);
                                prereqCodes.push(codigo);
                            }
                        });

                        $prerequisitoSelect.val(prereqCodes).trigger('change');
                    } else {
                        console.warn("No se recibieron prerrequisitos válidos.");
                    }

                    $prerequisitoSelect.prop('disabled', true);
                    $prerequisitoSelect.next('.select2-container').css('pointer-events', 'none');
                    $prerequisitoSelect.next('.select2-container').css('opacity', '0.7');
                },

                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los prerrequisitos.'
                    });
                },
                complete: function() {
                    document.getElementById("NivelRadio1").focus();
                }
            });


            document.getElementById('CodigoFacultad').onchange = function() {
                /* Referencia a los atributos data de la opción seleccionada */
                var mData = this.options[this.selectedIndex].dataset;

                /* Referencia a los input */
                var elCode = document.getElementById('CodFacul');
                var elName = document.getElementById('NombreFacul');

                /* Asignamos cada dato a su input*/
                elCode.value = mData.codigo;
                elName.value = mData.nombre;

            };

            document.getElementById('CodigoPrograma').onchange = function() {
                /* Referencia a los atributos data de la opción seleccionada */
                var mData = this.options[this.selectedIndex].dataset;

                /* Referencia a los input */
                var elCode = document.getElementById('CodProg');
                var elName = document.getElementById('NombreProg');

                /* Asignamos cada dato a su input*/
                elCode.value = mData.codigo;
                elName.value = mData.nombre;

            };
        }
        // Agrega esta función al final de tu script para determinar colores
        function obtenerColorPorCodigo(codigo) {
            if (!codigo) return '#6c757d'; // Color por defecto

            // Extraer números del código (ej: "MAT101" -> 101)
            const numeros = codigo.match(/\d+/);
            const num = numeros ? parseInt(numeros[0]) : 0;

            // Paleta de colores Bootstrap
            const colores = [
                '#dc3545', // rojo
                '#fd7e14', // naranja
                '#ffc107', // amarillo
                '#28a745', // verde
                '#20c997', // verde agua
                '#17a2b8', // cyan
                '#007bff', // azul
                '#6f42c1', // morado
                '#e83e8c' // rosa
            ];

            // Asignar color basado en el código
            return colores[num % colores.length];
        }
    </script>
    <!--  <script type="text/javascript">
        $('#requisitos').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script> -->
    <script>
        $(document).ready(function() {
            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear() + "-" + (month) + "-" + (day);
            $("#fechaupdate").val(today);
        })
    </script>
    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>
    <script type="text/javascript">
        function sumar() {
            var valor1 = document.getElementById('thti').value;
            var valor2 = document.getElementById('thtp').value;

            var resultado = parseInt(valor1) + parseInt(valor2);
            if (!isNaN(resultado)) {
                //document.getElementById('txt3').value = result;

                document.getElementById('tht').value = resultado;
            }

        }
    </script>
    </body>

</html>