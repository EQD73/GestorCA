<?php
require_once 'conexion2.php';

try {
    $sql = "
        SELECT 
            p.nombre_programa,
            ROUND(AVG(
                CASE 
                    WHEN (
                        (CASE WHEN LENGTH(TRIM(m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
                        (CASE WHEN LENGTH(TRIM(m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
                        (CASE WHEN LENGTH(TRIM(m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
                        (CASE WHEN LENGTH(TRIM(m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
                        (CASE WHEN LENGTH(TRIM(m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
                    ) >= 3 
                    THEN 100.0
                    ELSE ROUND(
                        (
                            (CASE WHEN LENGTH(TRIM(m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
                            (CASE WHEN LENGTH(TRIM(m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
                            (CASE WHEN LENGTH(TRIM(m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
                            (CASE WHEN LENGTH(TRIM(m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
                            (CASE WHEN LENGTH(TRIM(m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
                        ) / 3.0 * 100, 2
                    )
                END
            ), 2) AS avance
        FROM sistema.m1
        INNER JOIN sistema.programas p ON p.codigo_programa = m1.codigo_programa
        WHERE m1.ano_micro = '2025'
        GROUP BY p.codigo_programa
        ORDER BY p.codigo_programa;
    ";

    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultados);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
