<?php
include("config.php");


## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = "id>$1";
$searchQueryVal = array();
$searchQueryVal[] = 0;

if($searchValue != ''){
    $searchQuery .= " and (codigo_usuario ilike $2 or 
    nombres ilike $3 or 
    apellidos ilike $4 ) ";

     $searchQueryVal[] = '%'.$searchValue.'%';
     $searchQueryVal[] = '%'.$searchValue.'%';
     $searchQueryVal[] = '%'.$searchValue.'%';

}

## Total number of records without filter
$sql = "select count(*) as allcount from sistema.usuarios";
$result = pg_query($con,$sql);
$records = pg_fetch_assoc($result);
$totalRecords = $records['allcount'];

## Total number of record with filter
$sql = "select count(*) as allcount from sistema.usuarios where ".$searchQuery;
$result = pg_query_params($con,$sql,$searchQueryVal);
$records = pg_fetch_assoc($result);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$sql = "select * from sistema.usuarios where ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit $rowperpage OFFSET $row";

// codigo_usuario, nombres, apellidos, Celular, email_institucional, estado, codigo_rol

$empRecords = pg_query_params($con,$sql,$searchQueryVal);
$data = array();

while ($row = pg_fetch_assoc($empRecords)) {
    $data[] = array( 
        "codigo_usuario"=>$row['codigo_usuario'],
        "nombres"=>$row['nombres'],
        "apellidos"=>$row['apellidos'],
        "Celular"=>$row['Celular'],
        "email_institucional"=>$row['email_institucional'],
        "estado"=>$row['estado'],
        "codigo_rol"=>$row['codigo_rol']
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

   