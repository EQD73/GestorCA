<?php
session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];

require "conexion.php";

$query_periodo = "SELECT codigo_periodo, nombre_periodo, estado, descripcion FROM sistema.periodos WHERE estado='ACTIVO'";
$resultado_qp = pg_query($conexion, $query_periodo);
$query_roles = "SELECT * FROM sistema.roles WHERE codigo_rol='$codigo_rol'";
$resultado_qr = pg_query($conexion, $query_roles);
$objroles = pg_fetch_object($resultado_qr);
$nombre_rol = $objroles->nombre_rol;
$_SESSION['nombre_rol'] = $nombre_rol;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
</head>

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
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i>Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content container-fluid">
                <div class="container">
                    <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Periodo Académico: <?php echo $_SESSION['descripcion']; ?></h4>
                    <hr>
                </div>

                <div class="page-title">
                    <h3 class="text-center">Reporte de Consignador Academico</h3>
                    <!-- <p class="text-subtitle text-muted">Algunas estadisticas importantes</p> -->
                </div>
                <?php
                // Función para obtener opciones
                function getOptions($conexion, $valueColumn, $valueColumn2, $labelColumn, $table)
                {
                    $query = "SELECT DISTINCT $valueColumn, $valueColumn2, $labelColumn FROM $table WHERE $valueColumn IS NOT NULL AND ($valueColumn::TEXT != '' AND $valueColumn::TEXT != '0') ORDER BY $labelColumn";
                    //AND $valueColumn != '0'
                    $result = pg_query($conexion, $query);
                    $options = [];
                    while ($row = pg_fetch_assoc($result)) {
                        $options[] = $row;
                    }
                    return $options;
                }

                // Obtener opciones para los filtros
                $periodos = getOptions($conexion, "codigo_periodo", "nombre_periodo", "codigo_periodo", "sistema.m2");
                $programas = getOptions($conexion, "codigo_programa", "nombre_programa", "codigo_programa", "sistema.m2");
                $docentes = getOptions($conexion, "codigo_docente", "nombre_docente", "nombre_docente", "sistema.m2");
                $semestres = getOptions($conexion, "semestre", "semestre", "semestre", "sistema.m2");
                $grupos = getOptions($conexion, "grupo", "grupo", "grupo", "sistema.m2");
                //nombre_docente

                // Capturar valores del formulario
                $periodo = $_GET['periodo'] ?? '';
                $programa = $_GET['programa'] ?? '';
                $asignatura = $_GET['asignatura'] ?? '';
                $docente = $_GET['docente'] ?? '';
                $semestre = $_GET['semestre'] ?? '';
                $grupo = $_GET['grupo'] ?? '';

                // Consulta dinámica
                $sql = "SELECT * FROM sistema.m2 WHERE 1=1";
                if (!empty($periodo)) $sql .= " AND codigo_periodo = '$periodo'";
                if (!empty($programa)) $sql .= " AND codigo_programa = '$programa'";
                if (!empty($asignatura)) $sql .= " AND codigo_asignatura = '$asignatura'";
                if (!empty($docente)) $sql .= " AND codigo_docente = '$docente'";
                if (!empty($semestre)) $sql .= " AND semestre = $semestre";
                if (!empty($grupo)) $sql .= " AND grupo = $grupo";
                $sql .= " ORDER BY codigo_asignatura ASC, grupo ASC";

                $result = pg_query($conexion, $sql);
                ?>

                <div class="container mt-4">
                    <h4 class="text-center">Generador de Reportes por filtros</h4>

                    <!-- Formulario de Filtros -->
                    <form method="GET" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Periodo</label>
                            <select name="periodo" id="periodo" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($periodos as $p): ?>
                                    <option value="<?= $p['codigo_periodo'] ?>" <?= $p['codigo_periodo'] == $periodo ? 'selected' : '' ?>>
                                        <?= $p['codigo_periodo'] . " - " . $p['nombre_periodo'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Programa</label>
                            <select name="programa" id="programa" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($programas as $prog): ?>
                                    <option value="<?= $prog['codigo_programa'] ?>" <?= $prog['codigo_programa'] == $programa ? 'selected' : '' ?>>
                                        <?= $prog['codigo_programa'] . " - " . $prog['nombre_programa'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Asignatura</label>
                            <select name="asignatura" id="asignatura" class="form-select">
                                <option value="">Todas</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Docente</label>
                            <select name="docente" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($docentes as $doc): ?>
                                    <option value="<?= $doc['codigo_docente'] ?>" <?= $doc['codigo_docente'] == $docente ? 'selected' : '' ?>>
                                        <?= $doc['codigo_docente'] . " - " . $doc['nombre_docente'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Semestre</label>
                            <select name="semestre" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($semestres as $s): ?>
                                    <option value="<?= $s['semestre'] ?>" <?= $s['semestre'] == $semestre ? 'selected' : '' ?>>
                                        <?= $s['semestre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Grupo</label>
                            <select name="grupo" class="form-select">
                                <option value="">Todos</option>
                                <?php foreach ($grupos as $g): ?>
                                    <option value="<?= $g['grupo'] ?>" <?= $g['grupo'] == $grupo ? 'selected' : '' ?>>
                                        <?= $g['grupo'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center mt-3 gap-2">
                            <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Filtrar"><i class="fa-solid fa-filter"></i> Filtrar</button>

                        </div>
                    </form>

                    <div class="d-flex justify-content-center mt-3 gap-2">
                        <form method="GET" target="_blank" action="generar_pdf_rconsigna.php">
                            <input type="hidden" name="periodo" value="<?= $periodo ?>">
                            <input type="hidden" name="programa" value="<?= $programa ?>">
                            <input type="hidden" name="asignatura" value="<?= $asignatura ?>">
                            <input type="hidden" name="docente" value="<?= $docente ?>">
                            <input type="hidden" name="semestre" value="<?= $semestre ?>">
                            <input type="hidden" name="grupo" value="<?= $grupo ?>">
                            <button type="submit" class="btn btn-danger btn-ms" id="BtnGenerar" type="button" data-toggle="tooltip" data-placement="top" title="Generar PDF"><i class="fa-solid fa-file-pdf"></i> Generar PDF</button>
                        </form>
                    </div>
                    <!-- Tabla de Resultados -->
                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código Asignatura</th>
                                <th>Nombre Asignatura</th>
                                <th>Periodo</th>
                                <th>Docente</th>
                                <th>Programa</th>
                                <th>Semestre</th>
                                <th>Grupo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            <?php while ($row = pg_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $contador++ ?></td>
                                    <td><?= htmlspecialchars($row['codigo_asignatura']) ?></td>
                                    <td><?= htmlspecialchars($row['nombre_asignatura']) ?></td>
                                    <td><?= htmlspecialchars($row['codigo_periodo']) ?></td>
                                    <td><?= htmlspecialchars($row['nombre_docente']) ?></td>
                                    <td><?= htmlspecialchars($row['nombre_programa']) ?></td>
                                    <td><?= htmlspecialchars($row['semestre']) ?></td>
                                    <td><?= htmlspecialchars($row['grupo']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p class="text-center">2024 &copy; UniCorsalud </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>

    <script>
        $(document).ready(function() {
            function cargarAsignaturas() {
                var programa_id = $("#programa").val();
                var valor = $("#periodo").val();
                $.ajax({
                    url: "get_asignaturas_rconsigna.php",
                    type: "POST",
                    data: {
                        programa: programa_id,
                        periodo: valor
                    },
                    success: function(data) {
                        $("#asignatura").html(data);
                    }
                });
            }
            $("#programa").change(cargarAsignaturas);
            $("#filterForm").submit(function() {
                setTimeout(cargarAsignaturas, 500);
            });

            // Cargar asignaturas al cargar la página si ya hay un programa seleccionado
            if ($("#programa").val()) {
                cargarAsignaturas();
            }
        });
    </script>

</html>