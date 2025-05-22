<?php
$archivo = $_GET['archivo'] ?? '';
$ruta = __DIR__ . '/' . $archivo;

if (file_exists($ruta)) {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
    header('Content-Length: ' . filesize($ruta));
    readfile($ruta);
    // Eliminar el archivo si es temporal
    unlink($ruta);
    exit;
} else {
    echo "Archivo no encontrado.";
}
