<?php
// Ruta donde se guardará el archivo de respaldo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$folderPath = $_POST['backup_folder'];
    $folderPath = "../backups";
    
    // Validar que la carpeta seleccionada existe y es válida
    if (!is_dir($folderPath)) {
        echo json_encode(['status' => 'error', 'message' => 'Carpeta no válida.']);
        exit;
    }

    // Nombre del archivo de respaldo con fecha
    $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.backup';
    $filePath = rtrim($folderPath, '/') . '/' . $fileName;

    // Configuración de PostgreSQL
    $dbHost = 'localhost';
    $dbPort = '5434';
    $dbName = 'postgres';
    $dbUser = 'postgres';
    $dbPassword = 'Killa2022';
    $schema =  'sistema';

    // Comando pg_dump
    $command = "pg_dump -h $dbHost -p $dbPort -U $dbUser -F c -b -v -f $filename $dbName";

   
    // Ejecutar el comando
    $output = null;
    $resultCode = null;
    exec($command, $output, $resultCode);

    // Comprobar si el comando se ejecutó correctamente
    if ($resultCode === 0) {
        echo json_encode(['status' => 'success', 'message' => 'Respaldo creado exitosamente.', 'file' => $filePath]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al crear el respaldo.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup PostgreSQL</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Backup de Base de Datos PostgreSQL</h1>
    <form id="backupForm" method="POST">
        <div class="form-group">
            <label for="backupFolder">Selecciona la carpeta para guardar el backup:</label>
            <input type="file" id="backupFolder" class="form-control-file" webkitdirectory directory multiple>
        </div>
        <button type="submit" class="btn btn-primary">Generar Backup</button>
    </form>

    <div id="message" class="mt-3"></div>
</div>

<script>
    $(document).ready(function () {
        $('#backupForm').on('submit', function (e) {
            e.preventDefault();

            //var folder = $('#backupFolder').val();
            var folder = "../backups";
            if (!folder) {
                $('#message').html('<div class="alert alert-danger">Por favor, selecciona una carpeta.</div>');
                return;
            }

            var formData = new FormData();
            formData.append('backup_folder', folder);

            $.ajax({
                url: '',  // La misma página
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        $('#message').html('<div class="alert alert-success">' + result.message + '</div>');
                    } else {
                        $('#message').html('<div class="alert alert-danger">' + result.message + '</div>');
                    }
                }
            });
        });
    });
</script>
</body>
</html>
