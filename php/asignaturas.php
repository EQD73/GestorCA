<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$periodo = $_SESSION['codigo_periodo'];

include('conexion.php');

//select de tabla programas
$query_programas = "SELECT * FROM sistema.programas ORDER BY codigo_programa ASC ";
$resultado_qp = pg_query($conexion, $query_programas);
$num1 = pg_num_rows($resultado_qp);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        thead input {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
    <style>
        .contenedor-centrado {
            display: flex;
            justify-content: center;
            /* Centrado horizontal */
            /*align-items: center;*/
            /* Centrado vertical (si quieres) */
            height: 100vh;
            /* Ocupa toda la altura de la ventana */
        }

        table.dataTable {
            width: auto !important;
            /* Evita que el DataTable ocupe 100% */
        }
    </style>
</head>
<?php
if ($codigo_rol == '3' || $codigo_rol == '4' || $codigo_rol == '5' || $codigo_rol == '2') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                icon: "info",
                title: "Cuidado!",
                text: "Usted no tiene los permisos para ingresar a esta opción",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {
                if (result.value) {
                    window.location.href = "home.php";

                }
            });
        });
    </script>
<?php
} else {
?>

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
                                                    No ha ingresado informacion en las ultimas dos semanas
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
                                    <div class="d-none d-md-block d-lg-inline-block">Hola, <?php echo $nombre; ?></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#"><i data-feather="user"></i> Cuenta/Perfil</a>
                                    <!-- <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a> -->
                                    <!-- <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="container">
                    <h3 class="text-center">CRUD Tabla de Asignaturas</h3>
                    <div class="mb-6" id="exportButtons"></div>
                    <div class="row">
                        <div class="col-4 offset-9">
                            <div class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#modalAsignatura" style="font-size:0.8em" id="botonCrear">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Nueva Asignatura</button>
                            </div>
                        </div>
                    </div>
                    <br />
                    <br />


                    <div class="contenedor-centrado" style="font-size:0.8em">
                        <table id="datos_asignatura" class="table table-bordered table-striped display nowrap display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Periodo</th>
                                    <th>Semestre</th>
                                    <th>Grupo</th>
                                    <th>Código Prog.</th>
                                    <th>Nom. Programa</th>
                                    <th>Codigo Docente</th>
                                    <th>Nombre Docente</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th><input type=" text" placeholder="Buscar..." />
                                    </th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th></th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th><input type="text" placeholder="Buscar..." /></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class=" modal fade" id="modalAsignatura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Crear Asignatura</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form method="POST" id="formulario" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="codigo_asigna">Código Asignatura</label>
                                                <input type="text" name="codigo_asigna" id="codigo_asigna" class="form-control">
                                            </div>

                                            <div class="col-sm-9">
                                                <label for="nom_asigna">Nombre Asignatura</label>
                                                <input type="text" name="nom_asigna" id="nom_asigna" class="form-control" style="text-transform: uppercase">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="formGroup" class="form-label">Programa</label>
                                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="CodigoPrograma" name="CodigoPrograma">
                                                    <option value="" data-codigo="" data-nombre="" selected>Escoger Opción</option>
                                                    <?php
                                                    while ($obj = pg_fetch_object($resultado_qp)) { ?>
                                                        <option value="<?php echo $obj->codigo_programa; ?>" data-codigo="<?php echo $obj->codigo_programa; ?>" data-nombre="<?php echo $obj->nombre_programa; ?>"><?php echo $obj->codigo_programa;
                                                                                                                                                                                                                    echo "  |  ";
                                                                                                                                                                                                                    echo $obj->nombre_programa; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <input type="hidden" class="form-control form-control" id="CodProg" name="CodProg">

                                            <div class="col-sm-8">
                                                <label for="formGroup" class="form-label">Nombre del Programa</label>
                                                <input type="text" class="form-control form-control" id="NombreProg" name="NombreProg" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label for="semestre">Semestre</label>
                                                <input type="text" name="semestre" id="semestre" class="form-control">
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="grupo">Grupo</label>
                                                <input type="text" name="grupo" id="grupo" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="ihs">Periodo</label>
                                                <input type="text" name="periodo" id="periodo" class="form-control" value="<?php echo $periodo; ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="ihs">Int.Hor.Sem</label>
                                                <input type="text" name="ihs" id="ihs" class="form-control">
                                            </div>

                                            <div class="col-sm-2">
                                                <label for="Créditos">Créditos</label>
                                                <input type="text" name="creditos" id="creditos" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mt-2" id="req1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="cod_docente">Codigo Docente</label>
                                                <input type="text" name="cod_docente" id="cod_docente" class="form-control">
                                            </div>
                                            <div class="col-sm-8">
                                                <label for="nom_docente">Nombre Docente</label>
                                                <input type="text" name="nom_docente" id="nom_docente" class="form-control" style="text-transform: uppercase">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="id_asigna" id="id_asigna">
                                        <input type="hidden" name="operacion" id="operacion">
                                        <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                                    </div>
                                </div>
                            </form>
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
} ?>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Botones exportación -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear Asignatura");
                $("#action").val("Crear");
                $("#operacion").val("Crear");
            });

            //$('#datos_asignatura thead tr').clone(true).appendTo('#datos_asignatura thead');

            let table = $('#datos_asignatura').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'obtener_registrosAsignatura.php',
                    type: 'POST'
                },
                dom: "<'row align-items-center mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-copy"></i> Copiar',
                        className: 'btn btn-sm btn-secondary me-1 mb-1'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success me-1 mb-1' // ✅ Verde sólido
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-alt"></i> CSV',
                        className: 'btn btn-sm btn-primary me-1 mb-1' // 🔵 Azul sólido
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger mb-1', // 🔴 Rojo sólido
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            doc.styles.tableHeader.fontSize = 10;
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.title = {
                                fontSize: 16,
                                bold: true,
                                alignment: 'center',
                                margin: [0, 0, 0, 10]
                            };
                        }
                    }
                ],


                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                orderCellsTop: true,
                fixedHeader: true,
                responsive: true,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'codigo_asignatura'
                    },
                    {
                        data: 'nombre_asignatura'
                    },
                    {
                        data: 'periodo'
                    },
                    {
                        data: 'semestre'
                    },
                    {
                        data: 'grupo'
                    },
                    {
                        data: 'codigo_programa'
                    },
                    {
                        data: 'nombre_programa'
                    },
                    {
                        data: 'codigo_docente'
                    },
                    {
                        data: 'nombre_docente'
                    },
                    {
                        data: 'editar',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'borrar',
                        orderable: false,
                        searchable: false
                    }
                ]
            });



            $('#datos_asignatura thead tr:eq(1) th').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            });


            //Aquí código inserción
            $(document).on('submit', '#formulario', function(event) {
                event.preventDefault();
                var codigo_asigna = $('#codigo_asigna').val();
                var nombre_asigna = $('#nom_asigna').val();
                var semestre = $('#semestre').val();
                var grupo = $('#grupo').val();
                var periodo = $('#periodo').val();
                var cod_docente = $('#cod_docente').val();
                var nom_docente = $('#nom_docente').val();

                if (codigo_asigna != '' && nombre_asigna != '' && semestre != '' && grupo != '') {
                    $.ajax({
                        url: "crearAsignatura.php",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                icon: "success",
                                title: "Exito!",
                                text: data,
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            })
                        }
                    });
                    $('#formulario')[0].reset();
                    $('#req1').load('Requisitos.php');
                    /* $('#modalAsignatura').modal('hide'); */
                    /* removeModal('#modalAsignatura'); */
                    dataTable.ajax.reload();
                } else {
                    /*  */
                    Swal.fire({
                        icon: "info",
                        title: "Atención!",
                        text: "Algunos campos son obligatorios",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    })

                }
            });

            //Funcionalida de editar
            $(document).on('click', '.editar', function() {
                var id_asigna = $(this).attr("id");
                $.ajax({
                    url: "obtener_registroAsignatura.php",
                    method: "POST",
                    data: {
                        id_asigna: id_asigna
                    },
                    dataType: "json",
                    success: function(data) {

                        $('#modalAsignatura').modal('show');
                        $('#codigo_asigna').val(data.codigo_asignatura);
                        $('#nom_asigna').val(data.nombre_asignatura);
                        $('#CodigoPrograma').val(data.codigo_programa);
                        $('#CodProg').val(data.codigo_programa);
                        $('#NombreProg').val(data.nombre_programa);
                        $('#semestre').val(data.semestre);
                        $('#grupo').val(data.grupo);
                        $('#periodo').val(data.periodo);
                        $('#ihs').val(data.ihs);
                        $('#creditos').val(data.creditos);
                        $('#req1').load('Requisitos.php');
                        $('#requisitos').val(data.prerequisito)
                        $('#cod_docente').val(data.codigo_docente);
                        $('#nom_docente').val(data.nombre_docente);
                        $('.modal-title').text("Editar Usuario");
                        $('#id_asigna').val(id_asigna);
                        $('#action').val("Editar");
                        $('#operacion').val("Editar");

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
            });

            //Funcionalida de borrar
            $(document).on('click', '.borrar', function() {
                var id_asigna = $(this).attr("id");

                Swal.fire({
                    title: 'Estás seguro de borrar este registro de la asignatura: ' + id_asigna + ' ?',
                    text: "No podrás revertir los cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borralo!'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: "borrarAsignatura.php",
                            method: "POST",
                            data: {
                                id_asigna: id_asigna
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Exito!",
                                    text: data,
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                })
                                dataTable.ajax.reload();
                            }
                        });
                    } else {
                        return false;
                    }
                })
            })
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var miModal = document.getElementById('modalAsignatura');
            miModal.addEventListener('shown.bs.modal', function() {
                document.getElementById('codigo_asigna').focus();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#cod_docente').on('change', function() { // también puedes usar 'change' o 'keypress'
                var codigo = $(this).val();

                if (codigo !== '') {
                    $.ajax({
                        url: 'buscar_docente.php',
                        type: 'POST',
                        data: {
                            codigo_docente: codigo
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.nombre) {

                                $('#nom_docente').val(data.nombre);
                            } else {
                                $('#nom_docente').val('Docente no encontrado');
                            }
                        },
                        error: function() {
                            $('#nom_docente').val('Error en la búsqueda');
                        }
                    });
                }
            });
        });
    </script>


    <script type="text/javascript">
        document.getElementById('CodigoPrograma').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada */
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input */
            var elCode = document.getElementById('CodProg');
            var elName = document.getElementById('NombreProg');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            elName.value = mData.nombre;

            var dato = document.getElementById('CodProg').value;


            $.ajax({
                    url: "EnviarDato.php",
                    type: "post",
                    data: {
                        variable: dato
                    }
                })
                .done(function(data) {
                    //alert(data);
                    $('#req1').load('Requisitos.php');
                });
        };
    </script>

    <script type="text/javascript">
        function removeModal(target) {
            $(target).removeClass('in');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
            $(target).hide();
        }
    </script>
    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>



    </body>

</html>