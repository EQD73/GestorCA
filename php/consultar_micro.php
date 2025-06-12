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

$codperiodo = $_SESSION['codigo_periodo'];

$dbconn2 = pg_connection_reset($conexion);

$estado = $_SESSION['estado_periodo'] ?? null;
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

////**************************/////
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
$codigoConsulta = $id;

//select de tabla facultades
$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);

// select de tabla asignaturas

$query_asignaturas2 = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC";
$resultado_qas2 = pg_query($conexion, $query_asignaturas2);
$num2 = pg_num_rows($resultado_qas2);


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
$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='2' ORDER BY codigo_usuario ASC ";
$resultado_qu = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='4' ORDER BY codigo_usuario ASC ";
$resultado_qu2 = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='5' ORDER BY codigo_usuario ASC ";
$resultado_qu3 = pg_query($conexion, $query_usuarios);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style type="text/css">
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
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
</head>

<body>
    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-danger';
    $iconClass = 'bi-stack';
    $pageTitle = "Gestión de Microcuriculos"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
        <h3 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo MicroCurriculo - Editar Microcurriculo</h3>
        <!-- //inicio de nav-tab  -->

        <ul class="nav nav-pills mx-auto" id="pills-tab" role="tablist" style="width: fit-content;">
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
        <div class="row" id="form-visible">
            <div class="col-md-12 mt-2">
                <?php
                include('FormMicroConsulta.php'); ?>
            </div>
        </div>
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        function mostrar() {
            element = document.getElementById('form-visible');
            estado = element.style.display;
            if (estado == 'none') {
                element.style.display = 'block'
            }
        }
    </script>

    <script type="text/javascript">
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

        var codigocurso = document.getElementById('CodigoCurso').value;

        $.ajax({
            url: "EnviarCurso.php",
            type: "GET",
            data: {
                codigocurso: codigocurso
            },
            success: function(response) {
                console.log("Respuesta del backend:", response);

                const prerequisitos = response?.data?.prerequisitos;

                const $prerequisitoSelect = $('#requisitos2');

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