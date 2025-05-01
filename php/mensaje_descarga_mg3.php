<?php
$archivo = $_GET['archivo'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte generado</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
        Swal.fire({
            title: '¡Reporte generado!',
            text: 'Tu archivo se descargará automáticamente.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
            allowOutsideClick: false,
            willClose: () => {
                // Redirigir luego del mensaje
                window.location.href = 'graficas_micro3.php'; // Cambia esta ruta si es necesario
            }
        });

        // Descargar automáticamente después de una breve pausa
        setTimeout(() => {
            window.location.href = 'descargar_excel_mg3.php?archivo=<?= urlencode($archivo) ?>';
        }, 1000);
    </script>
</body>

</html>