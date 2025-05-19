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

    // Validar que los periodos(años) sean distintos
    if ($anio_origen === $anio_destino) {
        throw new Exception('No se puede trasladar microcurrículos dentro del mismo año.');
    }

    // Si no hay programas seleccionados
    if (empty($programas)) {
        throw new Exception('Debe seleccionar al menos un programa.');
    }

    // Construir la lista de códigos de programas seleccionados
    $programas_placeholders = implode(',', array_fill(0, count($programas), '?'));

    // Consulta para obtener los registros a trasladar
    $stmt = $pdo->prepare("
       SELECT m1.area_formacion, m1.codigo_asignaturacurso, m1.codigo_docente, m1.codigo_facultad, m1.codigo_programa,
            m1.creditos, m1.descripcion_intension, m1.estrategia_pyd, m1.grupo, m1.horas_trabajo,
            m1.modalidad, m1.nivel_formacion, m1.nombre_asignatura, m1.nombre_docente, m1.nombre_facultad,
            m1.nombre_programa, m1.nombre_proyecto, m1.proy_acciones, m1.proy_asignaturas, m1.proy_tematicas,
            m1.recursos, m1.ref_biblio, m1.ref_ingles, m1.ref_otra, m1.ref_webgrafia,
            m1.requisitos, m1.resultados_aprendizaje, m1.semestre, m1.tht, m1.thti, m1.thtp, m1.tipo_curso, m1.total_semanas_periodo,
            m1.u1_actividades, m1.u1_contenidos, m1.u1_cortesemanas, m1.u1_evaluacion, m1.u1_hi, m1.u1_hp, m1.u1_resultados,
            m1.u2_actividades, m1.u2_contenidos, m1.u2_cortesemanas, m1.u2_evaluacion, m1.u2_hi, m1.u2_hp, m1.u2_resultados,
            m1.u3_actividades, m1.u3_contenidos, m1.u3_cortesemanas, m1.u3_evaluacion, m1.u3_hi, m1.u3_hp, m1.u3_resultados,
            m1.u4_actividades, m1.u4_contenidos, m1.u4_cortesemanas, m1.u4_evaluacion, m1.u4_hi, m1.u4_hp, m1.u4_resultados,
            m1.u5_actividades, m1.u5_contenidos, m1.u5_cortesemanas, m1.u5_evaluacion, m1.u5_hi, m1.u5_hp, m1.u5_resultados        
        FROM sistema.m1 AS m1
        JOIN sistema.pensum AS p ON p.codigo_asignatura = m1.codigo_asignaturacurso
        WHERE p.codigo_programa IN ($programas_placeholders)
        AND m1.ano_micro = ?
        AND NOT EXISTS (
            SELECT 1 FROM sistema.m1 AS m_destino
            WHERE m_destino.codigo_asignaturacurso = m1.codigo_asignaturacurso
            AND m_destino.ano_micro = ?
        )
        ORDER BY m1.codigo_asignaturacurso
    ");

    // $params = array_merge($programas, [$anio_origen]); // Agregar los códigos de programa y el año de origen
    $params = array_merge($programas, [$anio_origen, $anio_destino]); // Agregar los códigos de programa y el año de origen

    $stmt->execute($params);

    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($registros) == 0) {
        throw new Exception('No se encontraron registros para trasladar.');
    }

    // Preparar la consulta para insertar los registros en el periodo destino
    $stmtInsert = $pdo->prepare("
        INSERT INTO sistema.m1 (
            area_formacion, codigo_asignaturacurso, codigo_docente, codigo_facultad, codigo_programa,
            creditos, descripcion_intension, estrategia_pyd, grupo, horas_trabajo,
            modalidad, nivel_formacion, nombre_asignatura, nombre_docente, nombre_facultad,
            nombre_programa, nombre_proyecto, proy_acciones, proy_asignaturas, proy_tematicas,
            recursos, ref_biblio, ref_ingles, ref_otra, ref_webgrafia,
            requisitos, resultados_aprendizaje, semestre, tht, thti, thtp, tipo_curso, total_semanas_periodo,
            u1_actividades, u1_contenidos, u1_cortesemanas, u1_evaluacion, u1_hi, u1_hp, u1_resultados,
            u2_actividades, u2_contenidos, u2_cortesemanas, u2_evaluacion, u2_hi, u2_hp, u2_resultados,
            u3_actividades, u3_contenidos, u3_cortesemanas, u3_evaluacion, u3_hi, u3_hp, u3_resultados,
            u4_actividades, u4_contenidos, u4_cortesemanas, u4_evaluacion, u4_hi, u4_hp, u4_resultados,
            u5_actividades, u5_contenidos, u5_cortesemanas, u5_evaluacion, u5_hi, u5_hp, u5_resultados,
            ano_micro, fecha_actualizacion
        )
        VALUES (
            :area_formacion, :codigo_asignaturacurso, :codigo_docente, :codigo_facultad, :codigo_programa,
            :creditos, :descripcion_intension, :estrategia_pyd, :grupo, :horas_trabajo,
            :modalidad, :nivel_formacion, :nombre_asignatura, :nombre_docente, :nombre_facultad,
            :nombre_programa, :nombre_proyecto, :proy_acciones, :proy_asignaturas, :proy_tematicas,
            :recursos, :ref_biblio, :ref_ingles, :ref_otra, :ref_webgrafia,
            :requisitos, :resultados_aprendizaje, :semestre, :tht, :thti, :thtp, :tipo_curso, :total_semanas_periodo,
            :u1_actividades, :u1_contenidos, :u1_cortesemanas, :u1_evaluacion, :u1_hi, :u1_hp, :u1_resultados,
            :u2_actividades, :u2_contenidos, :u2_cortesemanas, :u2_evaluacion, :u2_hi, :u2_hp, :u2_resultados,
            :u3_actividades, :u3_contenidos, :u3_cortesemanas, :u3_evaluacion, :u3_hi, :u3_hp, :u3_resultados,
            :u4_actividades, :u4_contenidos, :u4_cortesemanas, :u4_evaluacion, :u4_hi, :u4_hp, :u4_resultados,
            :u5_actividades, :u5_contenidos, :u5_cortesemanas, :u5_evaluacion, :u5_hi, :u5_hp, :u5_resultados,
            :ano_micro, :fecha_actualizacion
        )
    ");

    $fecha_actual = date('Y-m-d');
    $trasladados = 0;

    foreach ($registros as $registro) {
        // Insertar en destino
        $stmtInsert->execute([
            ':area_formacion' => $registro['area_formacion'],
            ':codigo_asignaturacurso' => $registro['codigo_asignaturacurso'],
            ':codigo_docente' => $registro['codigo_docente'],
            ':codigo_facultad'  => $registro['codigo_facultad'],
            ':codigo_programa' => $registro['codigo_programa'],
            ':creditos' => $registro['creditos'],
            ':descripcion_intension' => $registro['descripcion_intension'],
            ':estrategia_pyd' => $registro['estrategia_pyd'],
            ':grupo' => $registro['grupo'],
            ':horas_trabajo'  => $registro['horas_trabajo'],
            ':modalidad' => $registro['modalidad'],
            ':nivel_formacion' => $registro['nivel_formacion'],
            ':nombre_asignatura' => $registro['nombre_asignatura'],
            ':nombre_docente' => $registro['nombre_docente'],
            ':nombre_facultad' => $registro['nombre_facultad'],
            ':nombre_programa' => $registro['nombre_programa'],
            ':nombre_proyecto' => $registro['nombre_proyecto'],
            ':proy_acciones'  => $registro['proy_acciones'],
            ':proy_asignaturas' => $registro['proy_asignaturas'],
            ':proy_tematicas' => $registro['proy_tematicas'],
            ':recursos' => $registro['recursos'],
            ':ref_biblio' => $registro['ref_biblio'],
            ':ref_ingles' => $registro['ref_ingles'],
            ':ref_otra' => $registro['ref_otra'],
            ':ref_webgrafia' => $registro['ref_webgrafia'],
            ':requisitos' => $registro['requisitos'],
            ':resultados_aprendizaje' => $registro['resultados_aprendizaje'],
            ':semestre' => $registro['semestre'],
            ':tht' => $registro['tht'],
            ':thti' => $registro['thti'],
            ':thtp' => $registro['thtp'],
            ':tipo_curso' => $registro['tipo_curso'],
            ':total_semanas_periodo' => $registro['total_semanas_periodo'],
            ':u1_actividades' => $registro['u1_actividades'],
            ':u1_contenidos' => $registro['u1_contenidos'],
            ':u1_cortesemanas' => $registro['u1_cortesemanas'],
            ':u1_evaluacion'  => $registro['u1_evaluacion'],
            ':u1_hi' => $registro['u1_hi'],
            ':u1_hp' => $registro['u1_hp'],
            ':u1_resultados' => $registro['u1_resultados'],
            ':u2_actividades' => $registro['u2_actividades'],
            ':u2_contenidos' => $registro['u2_contenidos'],
            ':u2_cortesemanas' => $registro['u2_cortesemanas'],
            ':u2_evaluacion' => $registro['u2_evaluacion'],
            ':u2_hi' => $registro['u2_hi'],
            ':u2_hp' => $registro['u2_hp'],
            ':u2_resultados' => $registro['u2_resultados'],
            ':u3_actividades' => $registro['u3_actividades'],
            ':u3_contenidos' => $registro['u3_contenidos'],
            ':u3_cortesemanas' => $registro['u3_cortesemanas'],
            ':u3_evaluacion' => $registro['u3_evaluacion'],
            ':u3_hi' => $registro['u3_hi'],
            ':u3_hp' => $registro['u3_hp'],
            ':u3_resultados' => $registro['u3_resultados'],
            ':u4_actividades' => $registro['u4_actividades'],
            ':u4_contenidos' => $registro['u4_contenidos'],
            ':u4_cortesemanas' => $registro['u4_cortesemanas'],
            ':u4_evaluacion' => $registro['u4_evaluacion'],
            ':u4_hi' => $registro['u4_hi'],
            ':u4_hp' => $registro['u4_hp'],
            ':u4_resultados' => $registro['u4_resultados'],
            ':u5_actividades' => $registro['u5_actividades'],
            ':u5_contenidos' => $registro['u5_contenidos'],
            ':u5_cortesemanas' => $registro['u5_cortesemanas'],
            ':u5_evaluacion' => $registro['u5_evaluacion'],
            ':u5_hi' => $registro['u5_hi'],
            ':u5_hp' => $registro['u5_hp'],
            ':u5_resultados' => $registro['u5_resultados'],
            ':ano_micro' => $anio_destino,
            ':fecha_actualizacion' => $fecha_actual
        ]);

        $trasladados++;
    }

    $response['status'] = 'success';
    $response['message'] = "Se trasladaron $trasladados microcurrículos al periodo $destino.";
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
