<?php
require 'conexion2.php';

$response = ['status' => 'error', 'message' => ''];

try {
    $origen = $_POST['origen'] ?? '';
    $destino = $_POST['destino'] ?? '';
    $programas = $_POST['programas'] ?? [];
    $anio_origen = substr($origen, 0, 4);
    $anio_destino = substr($destino, 0, 4);

    if (!$origen || !$destino) {
        throw new Exception('Ambos periodos son requeridos.');
    }

    if ($anio_origen === $anio_destino) {
        throw new Exception('No se puede mostrar vista previa dentro del mismo año.');
    }

    if (empty($programas)) {
        throw new Exception('Debe seleccionar al menos un programa.');
    }

    $placeholders = implode(',', array_fill(0, count($programas), '?'));
    $sql = "
        SELECT m1.codigo_asignaturacurso, m1.nombre_asignatura, m1.codigo_docente, m1.nombre_docente
        FROM sistema.m1 AS m1
        JOIN sistema.pensum AS p ON p.codigo_asignatura = m1.codigo_asignaturacurso
        WHERE p.codigo_programa IN ($placeholders)
        AND m1.ano_micro = ?
        AND NOT EXISTS (
            SELECT 1 FROM sistema.m1 AS m_destino
            WHERE m_destino.codigo_asignaturacurso = m1.codigo_asignaturacurso
            AND m_destino.ano_micro = ?
        )
        ORDER BY m1.codigo_asignaturacurso ASC
    ";

    $stmt = $pdo->prepare($sql);
    $params = array_merge($programas, [$anio_origen, $anio_destino]);
    $stmt->execute($params);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultados) {
        throw new Exception('No se encontraron microcurrículos para trasladar.');
    }

    // Generar HTML
    $html = '';
    foreach ($resultados as $r) {
        $html .= "<tr>
            <td>{$r['codigo_asignaturacurso']}</td>
            <td>{$r['nombre_asignatura']}</td>
            <td>{$r['codigo_docente']} - {$r['nombre_docente']}</td>
            <td>{$anio_origen}</td>
            <td>Microcurrículo listo para traslado</td>
        </tr>";
    }

    $response['status'] = 'success';
    $response['html'] = $html;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
