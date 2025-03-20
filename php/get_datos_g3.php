<?php
include 'conexion6.php';

$docente = $_POST['docente'];
$ano_micro = $_POST['ano_micro'];

$query = "SELECT 
            sistema.m1.codigo_asignaturacurso, 
            sistema.m1.nombre_asignatura, 
            sistema.m1.grupo, 
            sistema.m1.nombre_programa, 
            sistema.m1.semestre, 
            ROUND(
                ( 
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
                ) / 5.0 * 100, 2
            ) AS avance,
            sistema.m1.fecha_actualizacion
          FROM sistema.m1
          WHERE sistema.m1.codigo_docente = ? AND sistema.m1.ano_micro = ?";

$stmt = $conn->prepare($query);
$stmt->execute([$docente, $ano_micro]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
