
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nivel1      = $_REQUEST['nivel1'];
$nivel2      = $_REQUEST['nivel2'];
$nivel3      = $_REQUEST['nivel3'];
$nivel4      = $_REQUEST['nivel4']; 

$update = ("UPDATE sistema.nivel 
	SET 
	nivel1  ='" .$nivel1. "',
    nivel2  ='" .$nivel2. "',
    nivel3  ='" .$nivel3. "',
    nivel4  ='" .$nivel4. "'
    
	
WHERE id='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='nivel.php';
    </script>";

?>
