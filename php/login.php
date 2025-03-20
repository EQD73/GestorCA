<?php

session_start();

include("conexion2.php");

// archivo: iniciar_sesion.php

//session_start();

// Función para eliminar cookies
function eliminarCookies() {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/'); // Expira todas las cookies
    }
}

// Destruir la sesión anterior y eliminar cookies
if (isset($_SESSION['codigo_usuario'])) {
    session_unset();   // Destruye variables de sesión
    session_destroy(); // Destruye la sesión
    eliminarCookies(); // Llama a la función para eliminar cookies
}


$codigo_usuario= (isset($_POST['codigo_usuario'])) ? $_POST['codigo_usuario'] : '';
$password= (isset($_POST['password'])) ? $_POST['password'] : '';
$pass= md5($password);

//echo "<script> alert('".$codigo_usuario."'); </script>";

//'".$codigo_usuario."'.

$consulta= "SELECT * FROM sistema.usuarios WHERE codigo_usuario='$codigo_usuario' AND password='$pass'";
$resultado= $pdo->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() >=1){
    $data= $resultado->fetchAll(PDO::FETCH_ASSOC);
    
    $_SESSION['codigo_usuario']= $codigo_usuario;
    foreach( $data as $valor){
    $_SESSION['nombres'] = $valor['nombres'];
    $_SESSION['codigo_rol'] = $valor['codigo_rol'];}
    //$_SESSION['estado']=$valor['estado'];}
}else{
    $_SESSION['codigo_usuario'] =null;
    $_SESSION['nombres'] =null;
    $_SESSION['codigo_rol'] = null;
    //$_SESSION['estado']=null;
    $data=null;
}

print json_encode($data);