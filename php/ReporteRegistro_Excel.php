<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
?>

<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Diligenciamiento por programas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .table tbody tr.texto-rojo td {
            color: #ff0000 !important;
            /* font-weight: bold !important; */
        }
    </style>
</head>
<style>
    .select2-container--default .select2-selection--single {
        /* background-color: #f8d7da; */
        /* Rojo atenuado (similar a Bootstrap danger-light) */
        border-color: #f5c6cb;
        /* Borde rojo claro */
        color: #721c24;
        /* Texto rojo oscuro */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #721c24;
        /* Texto del elemento seleccionado */
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #f8d7da;
        /* Color al hacer hover o seleccionar opción */
        color: #721c24;
    }
</style>


<body class="bg-light">

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

            <div class="container mt-5">
                <h2 class="text-center mb-4 fw-bold">Registro de Actividades</h2>
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Reporte Diligenciamiento por Programa</h5>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3 pe-3">
                        <button id="exportExcel" class="btn btn-success md-2"><i class="fa-solid fa-file-excel"></i> Exportar a Excel</button>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <div class="row g-3 mt-2">
                            <div class="col-md-2">
                                <label for="selectPeriodo" class="form-label">Periodo:</label>
                                <select id="selectPeriodo" class="form-select select2" name="codigo_programa" style="width: 100%">
                                    <option value="">Todos</option>
                                    <?php
                                    include 'conexion.php';
                                    $query = "SELECT codigo_periodo, nombre_periodo FROM periodos WHERE estado='ACTIVO' ORDER BY codigo_periodo ASC";
                                    $result = pg_query($conexion, $query);
                                    while ($row = pg_fetch_assoc($result)) {
                                        $value = $row['codigo_periodo'];
                                        $nombre = htmlspecialchars($row['nombre_periodo'], ENT_QUOTES); // evitar problemas con comillas
                                        echo "<option value='$value' data-nombre='$nombre'>{$value} | {$nombre}</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="col-md-3">
                                <label for="selectPrograma" class="form-label">Programa:</label>
                                <select id="selectPrograma" class="form-select select2" name="codigo_programa" style="width: 100%">
                                    <option value="">Todos</option>
                                    <?php
                                    include 'conexion.php';
                                    $query = "SELECT codigo_programa, nombre_programa FROM programas ORDER BY codigo_programa";
                                    $result = pg_query($conexion, $query);
                                    while ($row = pg_fetch_assoc($result)) {
                                        $value = $row['codigo_programa'];
                                        $nombre = htmlspecialchars($row['nombre_programa'], ENT_QUOTES); // evitar problemas con comillas
                                        echo "<option value='$value' data-nombre='$nombre'>{$value} | {$nombre}</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="nombre_programa" id="nombre_programa">
                            </div>

                            <div class="col-md-3">
                                <label for="selectAsignatura" class="form-label">Asignatura:</label>
                                <select id="selectAsignatura" class="form-select select2">
                                    <option value="">Todas</option>
                                </select>
                            </div>

                            <script>
                                document.getElementById('selectPrograma').addEventListener('change', function() {
                                    let codigoPrograma = this.value;
                                    let asignaturaSelect = document.getElementById('selectAsignatura');

                                    // Limpiar opciones previas
                                    asignaturaSelect.innerHTML = '<option value="">Todas</option>';

                                    if (codigoPrograma !== "") {
                                        fetch('get_asignaturas.php?codigo_programa=' + codigoPrograma)
                                            .then(response => response.json())
                                            .then(data => {
                                                data.forEach(asignatura => {
                                                    let option = document.createElement('option');
                                                    option.value = asignatura.codigo_asignatura;
                                                    option.textContent = asignatura.codigo_asignatura + " " + asignatura.nom_asignatura;
                                                    asignaturaSelect.appendChild(option);
                                                });
                                            })
                                            .catch(error => console.error('Error al cargar asignaturas:', error));
                                    }
                                });
                            </script>


                            <div class="col-md-2">
                                <label for="selectSemestre" class="form-label">Semestre:</label>
                                <select id="selectSemestre" class="form-select">
                                    <option value="">Todos</option>
                                    <?php
                                    $query = "SELECT DISTINCT semestre FROM sistema.pensum ORDER BY semestre";
                                    $result = pg_query($conexion, $query);
                                    while ($row = pg_fetch_assoc($result)) {
                                        echo "<option value='{$row['semestre']}'>Semestre {$row['semestre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="selectGrupo" class="form-label">Grupo:</label>
                                <select id="selectGrupo" class="form-select select2" style="width: 100%">
                                    <option value="">Todos</option>
                                    <?php
                                    for ($i = 1; $i <= 2; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Botón de actualización -->
                        <div class="text-center mt-4">
                            <!-- <button onclick="cargarDatos()" type="button" class="btn btn-primary">🔄 Aplicar Filtros</button> -->
                            <button type="button" id="filtrar-btn" class="btn btn-primary"><i class="fa-solid fa-filter"></i>Aplicar Filtros</button>
                        </div>

                        <hr>

                        <h4 class="mt-4">Diligenciamiento de Consignador Academico</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Programa</th>
                                    <th>Código</th>
                                    <th>Asignatura</th>
                                    <th>Semestre</th>
                                    <th>Grupo</th>
                                    <th>Codigo</th>
                                    <th>Docente</th>
                                    <th>Semanas Diligenciadas</th>
                                    <th>Fecha Consignación</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-datos">
                                <!-- <tr>
                                    <td colspan="7" class="text-center">Seleccione programa y año para ver los datos</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <script src="../assets/js/feather-icons/feather.min.js"></script>
            <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="../assets/js/main.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                function setNombrePrograma() {
                    const select = document.getElementById("selectPrograma");
                    const selectedOption = select.options[select.selectedIndex];
                    const nombrePrograma = selectedOption.getAttribute("data-nombre");
                    document.getElementById("nombre_programa").value = nombrePrograma;
                }
            </script>


            <script>
                $(document).ready(function() {

                    $("#filtrar-btn").click(function() {
                        let periodo = $("#selectPeriodo").val();
                        let programa = $("#selectPrograma").val();
                        let asignatura = $("#selectAsignatura").val();
                        let semestre = $("#selectSemestre").val();
                        let grupo = $("#selectGrupo").val();
                        //let nombrePrograma = $("#nombre_programa").val();

                        if (!periodo) {
                            alert("Seleccione un periodo");
                            return;
                        }

                        $.ajax({
                            url: "get_datos_r3.php",
                            type: "POST",

                            data: {
                                periodo,
                                programa,
                                asignatura,
                                semestre,
                                grupo

                            },
                            dataType: "json",
                            success: function(response) {

                                let tablaHtml = "";
                                let labels = [];
                                let data = [];

                                response.forEach(item => {
                                    // Determinar si la fila debe ser roja
                                    const esSinDato = item.codigo_docente === "Sin datos";
                                    const claseFila = esSinDato ? 'texto-rojo' : '';

                                    tablaHtml += `<tr class="${claseFila}">
                                        <td>${item.codigo_programa}</td>
                                        <td>${item.nombre_programa}</td>
                                        <td>${item.codigo_asignatura}</td>
                                        <td>${item.nom_asignatura}</td>
                                        <td>${item.semestre}</td>
                                        <td>${item.grupo}</td>
                                        <td>${item.codigo_docente}</td>
                                        <td>${item.nombre_docente}</td>                               
                                        <td>${item.semanas_diligenciadas}</td>
                                        <td>${item.fecha_registro}</td>
                                    </tr>`;

                                    labels.push(item.nombre_asignatura);
                                    data.push(item.avance);
                                });

                                $("#tabla-datos").html(tablaHtml);
                            }
                        });
                    });


                    $("#exportExcel").click(function() {
                        let periodo = $("#selectPeriodo").val();
                        let programa = $("#selectPrograma").val();
                        let asignatura = $("#selectAsignatura").val();
                        let semestre = $("#selectSemestre").val();
                        let grupo = $("#selectGrupo").val();
                        window.location.href = "export_excel_registro_r3.php?periodo=" + periodo + "&programa=" + programa + "&asignatura=" + asignatura + "&semestre=" + semestre + "&grupo=" + grupo; // Redirige a exportar_excel.php
                    });
                });
            </script>


            <script type="text/javascript">
                function cerrarsession() {
                    window.sessionStorage.removeItem("mostrarModal");
                }
            </script>


</body>

</html>