<?php
## Database configuration
include 'config.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = "id>$1";$searchQueryVal = array();
$searchQueryVal[] = 0;
if($searchValue != ''){
   $searchQuery .= " and (codigo_asignatura ilike $2 or 
        nom_asignatura ilike $3 or codigo_docente ilike $4)";
    $searchQueryVal[] = '%'.$searchValue.'%';
    $searchQueryVal[] = '%'.$searchValue.'%';
    $searchQueryVal[] = '%'.$searchValue.'%';
}

## Total number of records without filter
$sql = "select count(*) as allcount from sistema.asignaturas";
$result = pg_query($con,$sql);
$records = pg_fetch_assoc($result);
$totalRecords = $records['allcount'];

## Total number of record with filter
$sql = "select count(*) as allcount from sistema.asignaturas where ".$searchQuery;
$result = pg_query_params($con,$sql,$searchQueryVal);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$sql = "select * from sistema.asignaturas where ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit $rowperpage OFFSET $row";

$empRecords = pg_query_params($con,$sql,$searchQueryVal);
$data = array();

while ($row = pg_fetch_assoc($empRecords)) {
   $data[] = array( 
      "id"=>$row['id'],
      "codigo_asignatura"=>$row['codigo_asignatura'],
      "nombre_asignatura"=>$row['nom_asignatura'],
      "semestre"=>$row['semestre'],
      "grupo"=>$row['grupo'],
      "codigo_docente"=>$row['codigo_docente'],
      "nombre_docente"=>$row['nombre_docente'],
      "editar"=>'<button type="button" name="editar" id="'.$row["id"].'" class="btn btn-secondary btn-xs editar" style="font-size:0.8em"><i class="fa fa-pencil-square" aria-hidden="true"></i>Editar</button>',
      "borrar"=>'<button type="button" name="borrar" id="'.$row["id"].'" class="btn btn-danger btn-xs borrar" style="font-size:0.8em"><i class="fa fa-trash" aria-hidden="true"></i>Borrar</button>'

   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);