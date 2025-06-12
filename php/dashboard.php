<?php
session_start();
include("conexion2.php");

//consulta total docentes
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_usuarios FROM sistema.usuarios WHERE codigo_rol=2 AND estado='ACTIVO'");
$stmt->execute();
// fetchColumn() devuelve el valor de la primera columna de la primera fila del resultado
$totalUsuarios = (int) $stmt->fetchColumn();

//consulta total asignaturas
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_asignaturas FROM sistema.asignaturas");
$stmt->execute();
// fetchColumn() devuelve el valor de la primera columna de la primera fila del resultado
$totalAsignaturas = (int) $stmt->fetchColumn();

//consulta total programas
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_programas FROM sistema.programas");
$stmt->execute();
// fetchColumn() devuelve el valor de la primera columna de la primera fila del resultado
$totalProgramas = (int) $stmt->fetchColumn();

//consulta total periodos
$sql = "
        SELECT 
            estado,
            COUNT(*) AS total
        FROM 
            sistema.periodos
        GROUP BY 
            estado
    ";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// fetchAll devuelve un arreglo de filas: [ ['estado'=>'ACTIVO','total'=>3], ... ]
$rows = $stmt->fetchAll();

// Inicializamos los contadores con cero
$totales = [
    'ACTIVO'   => 0,
    'BLOQUEADO' => 0,
    'INACTIVO' => 0,
];

// Recorremos las filas y asignamos cada cantidad al estado correspondiente
foreach ($rows as $fila) {
    $estado = strtoupper($fila['estado']); // por si acaso viene en minúsculas
    $cantidad = (int) $fila['total'];

    if (array_key_exists($estado, $totales)) {
        $totales[$estado] = $cantidad;
    }
}

// Ahora $totales tiene algo como ['ACTIVO'=>3,'BLOQUEADO'=>2,'INACTIVO'=>5]
$totalActivo = $totales['ACTIVO'];
$totalBloqueado = $totales['BLOQUEADO'];
$totalInactivo = $totales['INACTIVO'];


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

// 3) Si se recibe un POST desde el modal, guardamos el período en sesión
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['CodPer'], $_POST['NomPer'], $_POST['EstadoPer'], $_POST['DescPer'])
) {
    $_SESSION['codigo_periodo']    = $_POST['CodPer'];
    $_SESSION['nombre_periodo']    = $_POST['NomPer'];
    $_SESSION['estado_periodo'] = $_POST['EstadoPer'];
    $_SESSION['descripcion']   = $_POST['DescPer'];

    // (Opcional) Guardar año o tablas relacionadas
    $_SESSION['anio']   = substr($_POST['CodPer'], 0, 4);
    $_SESSION['tablam1'] = "sistema.m1";
    $_SESSION['tablam2'] = "sistema.m2";
    $_SESSION['tablam3'] = "sistema.m3";

    // Redirigir a sí mismo para evitar repost de formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
//$estado = $_SESSION['estado_periodo'];
$estado = $_SESSION['estado_periodo'] ?? null;

// 4) Consulta de períodos para poblar el <select> del modal
$query_periodo = "
    SELECT codigo_periodo, nombre_periodo, estado, descripcion
    FROM sistema.periodos
    WHERE estado IN ('ACTIVO','BLOQUEADO')
    ORDER BY codigo_periodo DESC
";

$stmt = $pdo->query($query_periodo);
$resultado_qp = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 5) Saber si debemos mostrar el modal esta vez
$mostrarModal = false;
if (isset($_SESSION['mostrar_modal_periodo']) && $_SESSION['mostrar_modal_periodo'] === true) {
    $mostrarModal = true;
    // Desactivamos la bandera para que, en esta misma sesión, 
    // no vuelva a mostrarse tras recargas o tras elegir periodo
    unset($_SESSION['mostrar_modal_periodo']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">

    <style>
        <?php require('stylepanel.html'); ?>
    </style>
    <style>
        .chart-container {
            position: relative;
            height: 600px;
            width: 100%;
            /* o el valor que desees */
            margin: auto;
            /* centra el gráfico */
        }
    </style>
</head>

<body>
    <?php include("sidebar.html"); ?>
    <?php $iconColor = 'text-dark'; ?>
    <?php include("topbar.html"); ?>
    <?php include("content.html"); ?>


    <!-- ********************************* -->
    <!-- Modal para Seleccionar Período   -->
    <!-- ********************************* -->
    <div
        class="modal fade"
        id="ventana-modal"
        tabindex="-1"
        aria-labelledby="modalPeriodoLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form
                id="formPeriodo"
                action="dashboard.php"
                method="POST"
                class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPeriodoLabel">
                        Seleccionar Período Académico
                    </h5>
                </div>
                <div class="modal-body">
                    <label for="CodigoPeriodo" class="form-label">Período:</label>
                    <select
                        id="CodigoPeriodo"
                        class="form-select">
                        <option value="">-- Selecciona un período --</option>
                        <?php foreach ($resultado_qp as $fila): ?>
                            <option
                                value="<?= htmlspecialchars($fila['codigo_periodo']) ?>"
                                data-nombre="<?= htmlspecialchars($fila['nombre_periodo']) ?>"
                                data-estado="<?= htmlspecialchars($fila['estado']) ?>"
                                data-desc="<?= htmlspecialchars($fila['descripcion']) ?>">
                                <?= htmlspecialchars($fila['nombre_periodo']) ?> &nbsp;
                                (<?= htmlspecialchars($fila['estado']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Inputs ocultos para enviar con POST -->
                    <input type="hidden" name="CodPer" id="CodPer" />
                    <input type="hidden" name="NomPer" id="NomPer" />
                    <input type="hidden" name="EstadoPer" id="EstadoPer" />
                    <input type="hidden" name="DescPer" id="DescPer" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Modal -->

    <!-- ─── Scripts ─── -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <!-- ─── JS para apertura/cierre del modal y volcamiento de datos ─── -->
    <script>
        $(document).ready(function() {
            // Si hay que mostrar el modal (por login reciente), lo abrimos
            <?php if ($mostrarModal): ?>
                var modal = new bootstrap.Modal(
                    document.getElementById('ventana-modal')
                );
                modal.show();
            <?php endif; ?>

            // Al cambiar el select, volcamos los data-* a los inputs ocultos
            $('#CodigoPeriodo').on('change', function() {
                var selected = $(this).find(':selected');
                $('#CodPer').val(selected.val());
                $('#NomPer').val(selected.data('nombre'));
                $('#EstadoPer').val(selected.data('estado'));
                $('#DescPer').val(selected.data('desc'));
            });

            // Validar que el usuario seleccione algo antes de enviar
            $('#formPeriodo').on('submit', function(e) {
                if (!$('#CodigoPeriodo').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Período no seleccionado',
                        text: 'Debes elegir un período antes de continuar.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Enfocamos el select para que el usuario lo corrija
                        $('#CodigoPeriodo').focus().css('border', '2px solid red'); // Opcionalmente, cambiamos el borde a rojo para resaltar

                    });
                }
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('get_m1_avance_por_programa.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.nombre_programa);
                    const avances = data.map(item => item.avance);

                    const ctx = document.getElementById('graficoAvancePorPrograma').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: avances,
                                backgroundColor: [
                                    '#4CAF50', '#2196F3', '#FF9800', '#E91E63', '#9C27B0', '#3F51B5', '#F44336'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right'
                                },
                                title: {
                                    display: true,
                                    text: 'Porcentaje de Avance por Programa'
                                },
                                datalabels: {
                                    color: '#fff',
                                    formatter: (value, context) => value + '%',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels] // <- ACTIVA el plugin aquí
                    });
                })
                .catch(error => console.error('Error cargando avance por programa:', error));
        });
    </script>
    <!-- Chart.js y plugin ya deben estar cargados -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('get_m2_avance_por_programa.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.nombre_programa);
                    const avances = data.map(item => item.avance);

                    const ctx = document.getElementById('graficoAvanceM2').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: avances,
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#8BC34A',
                                    '#FF5722', '#00BCD4', '#9C27B0'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right'
                                },
                                title: {
                                    display: true,
                                    text: 'Porcentaje de Avance por Programa'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw;
                                            return `${label}: ${value}%`;
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#fff',
                                    /* formatter: function(value, context) {
                                        const label = context.chart.data.labels[context.dataIndex];
                                        return `${label}\n${value}%`;
                                    }, */
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    },
                                    align: 'center',
                                    anchor: 'center'
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                })
                .catch(error => console.error('Error al cargar gráfico m2:', error));
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('get_m3_avance_por_programa.php') // o tu ruta real
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.nombre_programa);
                    const valores = data.map(item => item.avance);

                    const ctx = document.getElementById('graficoAvanceM3').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: valores,
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56',
                                    '#4BC0C0', '#9966FF', '#FF9F40',
                                    '#C9CBCF', '#F7464A', '#46BFBD', '#FDB45C'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right'
                                },
                                title: {
                                    display: true,
                                    text: 'Porcentaje de Avance por Programa'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw;
                                            return `${label}: ${value}%`;
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#fff',
                                    /* formatter: function(value, context) {
                                        const label = context.chart.data.labels[context.dataIndex];
                                        return `${label}\n${value}%`;
                                    }, */
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    },
                                    align: 'center',
                                    anchor: 'center'
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                })
                .catch(error => console.error('Error al cargar gráfico m2:', error));
        });
    </script>


</body>

</html>