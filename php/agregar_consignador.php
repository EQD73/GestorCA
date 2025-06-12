<?php
session_start();
include('conexion2.php');
include('conexion.php');

// 1) Si no hay usuario logueado, redirigir a la pantalla de login
if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
    exit();
}

// 2) Recuperar datos del usuario para mostrar (opcional)
$codigo_rol = $_SESSION['codigo_rol'];
$nombre     = $_SESSION['nombres'];
$apellido   = $_SESSION['apellidos'];

$nombre = explode(" ", trim($nombre))[0];
$apellido = explode(" ", trim($apellido))[0];

$estadoper = $_SESSION['estado_periodo'];
$estado = $_SESSION['estado_periodo'] ?? null;
$codperiodo = $_SESSION['codigo_periodo'] ?? null;

$query_roles = "SELECT nombre_rol FROM sistema.roles WHERE codigo_rol = :codigo_rol";
$stmt = $pdo->prepare($query_roles);
$stmt->execute(['codigo_rol' => $codigo_rol]);
$objroles = $stmt->fetch(PDO::FETCH_OBJ);

if ($objroles) {
    $_SESSION['nombre_rol'] = $objroles->nombre_rol;
    $nombre_rol = $objroles->nombre_rol;
} else {
    $_SESSION['nombre_rol'] = null; // o maneja el caso según necesites
}

// select de tabla asignaturas
$codigousuario = $_SESSION['codigo_usuario'];
$query_carga = "SELECT
	dap.*,
	p.nombre_programa,
    p.codigo_coordinador, 
    p.nom_coordinador,
	u.nomcompleto,
	p.codigo_facultad,
	f.nombre_facultad,
    a.nom_asignatura   
   
FROM
	sistema.docente_asignaturas_periodo dap 
INNER JOIN sistema.programas p  ON dap.codigo_programa = p.codigo_programa
INNER JOIN sistema.asignaturas a  ON dap.codigo_asignatura = a.codigo_asignatura
INNER JOIN sistema.usuarios u  ON dap.codigo_docente = u.codigo_usuario::varchar
INNER JOIN sistema.facultades f  ON p.codigo_facultad = f.codigo_facultad
WHERE dap.codigo_docente='$codigousuario' AND codigo_periodo='$codperiodo'";
$resultado_qasig = pg_query($conexion, $query_carga);
$num2 = pg_num_rows($resultado_qasig);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='2' ORDER BY codigo_usuario ASC ";
$resultado_qu = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='4' ORDER BY codigo_usuario ASC ";
$resultado_qu2 = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='5' ORDER BY codigo_usuario ASC ";
$resultado_qu3 = pg_query($conexion, $query_usuarios);

//select de tabla facultades
$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);

// select de tabla asignaturas
$query_asignaturas = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC";
$resultado_qa = pg_query($conexion, $query_asignaturas);
$num2 = pg_num_rows($resultado_qa);

// select de tabla asignaturas

$query_asignaturas2 = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC";
$resultado_qa2 = pg_query($conexion, $query_asignaturas2);
$num2 = pg_num_rows($resultado_qa2);

// select de tabla programas

$query_programas = "SELECT * FROM sistema.programas ORDER BY codigo_programa ASC ";
$resultado_qp = pg_query($conexion, $query_programas);
$num3 = pg_num_rows($resultado_qp);

// select de tabla periodo

$query_periodo = "SELECT * FROM sistema.periodos WHERE estado='ACTIVO' AND codigo_periodo='$codperiodo'";
$resultado_qper = pg_query($conexion, $query_periodo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
    <style type="text/css">
        .inputClass {
            font-weight: bold;
        }

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
</head>

<?php
$estadoper = $_SESSION['estado_periodo'];
if ($estadoper == 'BLOQUEADO') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                icon: "info",
                title: "Cuidado!",
                text: "Usted no puede ingresar Consignación en un periodo Cerrado o Bloqueado. Solo Consultar",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {
                if (result.value) {
                    window.location.href = "Consignador.php";

                }
            });
        });
    </script>
<?php
} else {
?>

    <body>
        <?php include("sidebar.html");
        //Define esto antes de incluir el topbar -->
        $iconColor = 'text-danger';
        $iconClass = 'bi-stack';
        $pageTitle = "Gestión de Consignador Académico"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
        include("topbar.html"); ?>
        <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
        <main id="content">
            <h3 class="text-center mt-2" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo Consignador Académico - Agregar registro</h3>
            <!-- //inicio de nav-tab  -->
            <ul class="nav nav-pills mx-auto" id="pills-tab" role="tablist" style="width: fit-content;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Información General</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Desarrollo de la asignatura (Semanas)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Validación</button>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12 mt-2">
                    <?php include('FormConsignador.php'); ?>
                </div>
            </div>

            <footer>
                <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
            </footer>
        </main>
    <?php
}
    ?>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        document.getElementById('CodigoCurso').onchange = function() {
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input */
            var elCode = document.getElementById('CodigoCur');
            var elName = document.getElementById('NombreCurso');
            var elGroup = document.getElementById('grupo');
            var elSem = document.getElementById('semestre');
            var elcodp = document.getElementById('CodigoPrograma');
            var elnomp = document.getElementById('NombreProg');
            var elcoddoc = document.getElementById('CodigoDocente');
            var elnomdoc = document.getElementById('NomDocente');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            elName.value = mData.nombre;
            elGroup.value = mData.grupo;
            elSem.value = mData.semestre;
            elcodp.value = mData.codprog;
            elnomp.value = mData.nomprog;
            elcoddoc.value = mData.coddocente;
            elnomdoc.value = mData.nomdocente;

            //validar que exista microcurriculo antes de crear consignacion
            var codasig = document.getElementById('CodigoCur').value;
            var codgrup = document.getElementById('grupo').value;
            console.log(codasig + " " + codgrup);
            $.ajax({
                url: "confirmarMicro.php",
                method: "POST",
                data: {
                    codasig: codasig,
                    codgrup: codgrup
                },
                success: function(data) {
                    console.log(data);
                    if (data.trim() == "null") {
                        //alert('aqui estoy');
                        return false;
                    } else {
                        //alert(data);
                        Swal.fire({
                            icon: "success",
                            title: "Atención!",
                            text: "Esta asignatura No tiene Microcurriculo generado. Por favor ingrese MicroCurriculo antes de diligenciar el consignador",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = "Consignador.php";
                            }

                        })
                    }
                }
            });

            //validar formulario por codigo programa
            var dato = document.getElementById('CodigoPrograma').value;
            $.ajax({
                    url: "EnviarDato.php",
                    type: "post",
                    data: {
                        variable: dato
                    }
                })
                .done(function(data) {
                    //alert(data);
                    $('#pills-2').load('FormsConsigna.php');
                });
        };
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const topbar = document.getElementById('topbar');
            const content = document.getElementById('content');
            const btnToggle = document.getElementById('btnToggleSidebar');
            const sidebarToggler = document.querySelector('.sidebar-toggler');

            // Función para alternar la clase 'collapsed'
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');

                // Cambiar el ícono del botón hamburguesa (bi-list ↔ bi-x)
                const icon = btnToggle.querySelector('i');
                icon.classList.toggle('bi-list');
                icon.classList.toggle('bi-x');
            }

            // Cuando se hace clic en el botón hamburguesa
            btnToggle.addEventListener('click', toggleSidebar);

            // Cuando se hace clic en el botón “X” del sidebar
            sidebarToggler.addEventListener('click', () => {
                sidebar.classList.add('collapsed');
                topbar.classList.add('collapsed');
                content.classList.add('collapsed');
            });
        });
    </script>

    <script type="text/javascript">
        function cerrarsession(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Vas a salir del sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
    </script>
    </body>

</html>