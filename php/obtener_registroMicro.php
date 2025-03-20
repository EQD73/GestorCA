<?php

include('conexion.php'); 
 /*  $idvalor = $_POST['id_micro'];
  echo $value;
  
  $sqlvalue="UPDATE sistema.temporal SET valor2 ='".$idvalor."' WHERE id='1'";
  $resultvalue= pg_query($conexion,$sqlvalue); */

// Verifica que el ID fue enviado
if (isset($_POST['id'])) {
  $id = intval($_POST['id']); // Asegúrate de sanitizar el input
  echo $id;
  $query = "SELECT * FROM sistema.m1 WHERE id = $1";
  $resultado = pg_query_params($conexion, $query, [$id]);

  if ($resultado && pg_num_rows($resultado) > 0) {
      $registro = pg_fetch_assoc($resultado);
      echo json_encode($registro);
  } else {
      echo json_encode(['error' => 'Registro no encontrado.']);
  }
} else {
  echo json_encode(['error' => 'ID no recibido.']);
}
?>