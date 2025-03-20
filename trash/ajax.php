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
$searchQuery = "id>$1";
$searchQueryVal = array();
$searchQueryVal[] = 0;

if($searchValue != ''){
     $searchQuery .= " and (emp_name ilike $2 or 
          email ilike $3 or 
          city ilike $4 ) ";

     $searchQueryVal[] = '%'.$searchValue.'%';
     $searchQueryVal[] = '%'.$searchValue.'%';
     $searchQueryVal[] = '%'.$searchValue.'%';

}

## Total number of records without filter
$sql = "select count(*) as allcount from employees";
$result = pg_query($con,$sql);
$records = pg_fetch_assoc($result);
$totalRecords = $records['allcount'];


## Total number of record with filter
$sql = "select count(*) as allcount from employees where ".$searchQuery;
$result = pg_query_params($con,$sql,$searchQueryVal);
$records = pg_fetch_assoc($result);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$sql = "select * from employees where ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit $rowperpage OFFSET $row";

$empRecords = pg_query_params($con,$sql,$searchQueryVal);
$data = array();

while ($row = pg_fetch_assoc($empRecords)) {
    $data[] = array( 
        "emp_name"=>$row['emp_name'],
        "email"=>$row['email'],
        "gender"=>$row['gender'],
        "salary"=>$row['salary'],
        "city"=>$row['city']
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
