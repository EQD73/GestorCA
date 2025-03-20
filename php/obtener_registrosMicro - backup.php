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
session_start();
$codigo_usuario=$_SESSION['codigo_usuario'];
$codigo_rol=$_SESSION['codigo_rol'];
//$searchQuery="codigo_docente="
$searchQuery = "id>$1";
$searchQueryVal = array();
$searchQueryVal[] = 0;
if($searchValue != ''){
   $searchQuery .= " and (codigo_asignaturacurso ilike $2 or 
        nombre_asignatura ilike $3) and codigo_docente=$4";

       /*  " and (codigo_asignaturacurso ilike $2 or 
        nombre_asignatura ilike $3) and codigo_docente=$codigo_usuario::varchar"; */


    $searchQueryVal[] = '%'.$searchValue.'%';
    $searchQueryVal[] = '%'.$searchValue.'%';
    $searchQueryVal[] = '.$codigo_usuario.';

}

## Total number of records without filter 
/* session_start(); */
$tablam1=$_SESSION['tablam1']; 
/* echo $tablam1; */
if ($codigo_rol=='1'){
   $sql = "select count(*) as allcount from $tablam1";
}else{   
$sql = "select count(*) as allcount from $tablam1 where codigo_docente=$codigo_usuario::varchar";
}
$result = pg_query($con,$sql);
$records = pg_fetch_assoc($result);
$totalRecords = $records['allcount'];

## Total number of record with filter /* 
$sql = "select count(*) as allcount from $tablam1 where ".$searchQuery;
$result = pg_query_params($con,$sql,$searchQueryVal);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
/* $sql = "select * from $tablam1 where ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit $rowperpage OFFSET $row"; */
if ($codigo_rol=='1'){
   $sql = "SELECT * FROM $tablam1";   
}else{   
$sql = "SELECT * FROM $tablam1 WHERE codigo_docente=$codigo_usuario::varchar";
}

$empRecords = pg_query($con,$sql);
$data = array();

while ($row = pg_fetch_assoc($empRecords)) {
   $data[] = array( 
      "id"=>$row['id'],
      "Codigo"=>$row['codigo_asignaturacurso'],
      "Nombre"=>$row['nombre_asignatura'],
      "Grupo"=>$row['grupo'],
      "Codigodoc"=>$row['codigo_docente'],
      "Docente"=>$row['nombre_docente'],
      "semestre"=>$row['semestre'],
      "Programa"=>$row['nombre_programa'],
      "editar"=>'<button type="button" name="editar" id="'.$row["id"].'" class="btn btn-secondary btn-xs editar" style="font-size:0.8em"><i class="fa fa-pencil-square" aria-hidden="true"></i>Editar</button>',
      "borrar"=>'<button type="button" name="borrar" id="'.$row["id"].'" class="btn btn-danger btn-xs borrar" style="font-size:0.8em"><i class="fa fa-trash" aria-hidden="true"></i>Borrar</button>',
      "imprimir"=>'<button type="button" name="imprimir" id="'.$row["id"].'" class="btn btn-success btn-xs imprimir" style="font-size:0.8em"><i class="fa fa-file-pdf" aria-hidden="true"></i>Impr.PDF</button>'
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