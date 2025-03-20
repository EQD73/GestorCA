<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>

    <!-- Table -->
    <table id="empTable" class='display dataTable'>

        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Rol</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
        </thead>

    </table>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <scrpt src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></scrpt>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'ajax2.php'
                },
                'columns': [{
                        data: 'codigo_usuario'
                    },
                    {
                        data: 'nombres'
                    },
                    {
                        data: 'apellidos'
                    },
                    {
                        data: 'Celular'
                    },
                    {
                        data: 'email_institucional'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: 'codigo_rol'
                    },
                ]
            });
        });
    </script>

</body>

</html>