<?php

## Database configuration
include 'config.php';



## Search 
session_start();
$codigo_usuario=$_SESSION['codigo_usuario'];
$codigo_rol=$_SESSION['codigo_rol'];
$tablam3=$_SESSION['tablam3'];
$codperiodo=$_SESSION['codigo_periodo'];

$sqlp="SELECT * FROM sistema.programas WHERE codigo_coordinador='$codigo_usuario'";
$resp=pg_query($con,$sqlp);
$objp=pg_fetch_object($resp);
//

if ($codigo_rol=='4'){ 
  $sql = "SELECT * FROM $tablam3 WHERE codigo_periodo='$codperiodo' AND codigo_programa='$objp->codigo_programa'";
}
## 

## Fetch records
if ($codigo_rol=='1' || $codigo_rol=='5'){
   $sql = "SELECT * FROM $tablam3 WHERE codigo_periodo='$codperiodo'";   
}else if ($codigo_rol=='2'){   
$sql = "SELECT * FROM $tablam3 WHERE codigo_docente=$codigo_usuario::varchar AND codigo_periodo='$codperiodo'";
}

$empRecords = pg_query($con,$sql);
$data = array();

if ($codigo_rol=='2' || $codigo_rol=='4'){ 
while ($row = pg_fetch_assoc($empRecords)) {
   $data[] = array( 
      "id"=>$row['id'],
      "Codigo"=>$row['codigo_asignatura'],
      "Nombre"=>$row['nombre_asignatura'],
      "Grupo"=>$row['grupo'],
      "Codigodoc"=>$row['codigo_docente'],
      "Docente"=>$row['nombre_docente'],
      "semestre"=>$row['semestre'],
      "Programa"=>$row['nombre_programa'],
      "acciones"=>'<button type="button" name="registrar" id="'.$row["id"].'" class="btn btn-primary btn-xs registrar" style="font-size:0.8em"><i class="fa fa-pencil-square" aria-hidden="true"></i>Registro</button><button type="button" name="borrar" id="'.$row["id"].'" class="btn btn-danger btn-xs borrar" style="font-size:0.8em" disabled><i class="fa fa-trash" aria-hidden="true"></i>Eliminar</button><button type="button" name="imprimir" id="'.$row["id"].'" class="btn btn-success btn-xs imprimir" style="font-size:0.8em"><i class="fa fa-file-pdf" aria-hidden="true"></i>ImpPDF</button>'
   );
}
}else{
   while ($row = pg_fetch_assoc($empRecords)) {
      $data[] = array( 
         "id"=>$row['id'],
         "Codigo"=>$row['codigo_asignatura'],
         "Nombre"=>$row['nombre_asignatura'],
         "Grupo"=>$row['grupo'],
         "Codigodoc"=>$row['codigo_docente'],
         "Docente"=>$row['nombre_docente'],
         "semestre"=>$row['semestre'],
         "Programa"=>$row['nombre_programa'],
         "acciones"=>'<button type="button" name="registrar" id="'.$row["id"].'" class="btn btn-primary btn-xs registrar" style="font-size:0.8em"><i class="fa fa-pencil-square" aria-hidden="true"></i>Registro</button><button type="button" name="borrar" id="'.$row["id"].'" class="btn btn-danger btn-xs borrar" style="font-size:0.8em"><i class="fa fa-trash" aria-hidden="true"></i>Eliminar</button><button type="button" name="imprimir" id="'.$row["id"].'" class="btn btn-success btn-xs imprimir" style="font-size:0.8em"><i class="fa fa-file-pdf" aria-hidden="true"></i>ImpPDF</button>'
      );
   }
}

## Response
$response = array(
  "aaData" => $data
);

echo json_encode($response);