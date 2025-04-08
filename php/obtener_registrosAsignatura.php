<?php
session_start();
$periodo = $_SESSION['codigo_periodo'];
include 'config.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// Parámetros de DataTables
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];
$searchValueGlobal = $_POST['search']['value'];

// Validar columnas permitidas
$validColumns = [
   'codigo_asignatura' => 'a.codigo_asignatura',
   'nombre_asignatura' => 'a.nom_asignatura',
   'codigo_docente' => 'a.codigo_docente',
   'nombre_docente' => 'a.nombre_docente',
   'periodo' => 'a.periodo',
   'semestre' => "CAST(a.semestre AS TEXT)",
   'grupo' => "CAST(a.grupo AS TEXT)",
   'codigo_programa' => 'a.codigo_programa',
   'nombre_programa' => 'p.nombre_programa',
   'id' => 'a.id'
];

if (!array_key_exists($columnName, $validColumns)) {
   $columnName = 'id';
}

$searchQuery = "a.id > $1";
$searchQueryVal = [0];
$paramIndex = 2;
$filters = [];

// Búsqueda global (search general de DataTable)
if ($searchValueGlobal !== '') {
   $conditions = [];
   foreach ($validColumns as $alias) {
      if ($alias !== 'a.id') {
         $conditions[] = "$alias ILIKE \$$paramIndex";
         $searchQueryVal[] = '%' . $searchValueGlobal . '%';
         $paramIndex++;
      }
   }
   $filters[] = '(' . implode(' OR ', $conditions) . ')';
}

// Búsqueda por columnas individuales
foreach ($_POST['columns'] as $col) {
   $colName = $col['data'];
   $colSearch = $col['search']['value'];

   if (array_key_exists($colName, $validColumns) && $colSearch !== '') {
      $filters[] = $validColumns[$colName] . " ILIKE \$$paramIndex";
      $searchQueryVal[] = '%' . $colSearch . '%';
      $paramIndex++;
   }
}

// Filtro por periodo obligatorio
$filters[] = "a.periodo = \$$paramIndex";
$searchQueryVal[] = $periodo;

if (!empty($filters)) {
   $searchQuery .= " AND " . implode(" AND ", $filters);
}

// Total sin filtro
$resTotal = pg_query($con, "SELECT COUNT(*) AS allcount FROM sistema.asignaturas");
$totalRecords = pg_fetch_result($resTotal, 0, 'allcount');

// Total con filtro
$sqlCount = "SELECT COUNT(*) AS allcount FROM sistema.asignaturas a 
             INNER JOIN sistema.programas p ON a.codigo_programa = p.codigo_programa 
             WHERE $searchQuery";
$resFiltered = pg_query_params($con, $sqlCount, $searchQueryVal);
$totalRecordwithFilter = pg_fetch_result($resFiltered, 0, 'allcount');

// Datos filtrados
$sql = "SELECT a.*, p.nombre_programa 
        FROM sistema.asignaturas a 
        INNER JOIN sistema.programas p ON a.codigo_programa = p.codigo_programa 
        WHERE $searchQuery 
        ORDER BY {$validColumns[$columnName]} $columnSortOrder 
        LIMIT $rowperpage OFFSET $row";
$result = pg_query_params($con, $sql, $searchQueryVal);

// Formar array de datos
$data = [];
while ($row = pg_fetch_assoc($result)) {
   $data[] = [
      "id" => $row['id'],
      "codigo_asignatura" => $row['codigo_asignatura'],
      "nombre_asignatura" => $row['nom_asignatura'],
      "periodo" => $row['periodo'],
      "semestre" => $row['semestre'],
      "grupo" => $row['grupo'],
      "codigo_programa" => $row['codigo_programa'],
      "nombre_programa" => $row['nombre_programa'],
      "codigo_docente" => $row['codigo_docente'],
      "nombre_docente" => $row['nombre_docente'],
      "editar" => '<button type="button" name="editar" id="' . $row["id"] . '" class="btn btn-secondary btn-xs editar" style="font-size:0.8em"><i class="fa fa-pencil-square" aria-hidden="true"></i>Editar</button>',
      "borrar" => '<button type="button" name="borrar" id="' . $row["id"] . '" class="btn btn-danger btn-xs borrar" style="font-size:0.8em"><i class="fa fa-trash" aria-hidden="true"></i>Borrar</button>'
   ];
}

// Enviar respuesta
echo json_encode([
   "draw" => intval($draw),
   "iTotalRecords" => $totalRecords,
   "iTotalDisplayRecords" => $totalRecordwithFilter,
   "aaData" => $data
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
