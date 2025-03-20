<?php

// File: update_password.php

// Conexión a la base de datos
require 'db_connection.php';
include('scriptsweet.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
   //echo $token;
    $newPassword = md5($_POST['password']);

    // Verificar el token
    $stmt = $pdo->prepare('SELECT email, expires FROM sistema.password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();

    //echo date('U');

    if ($resetRequest && $resetRequest['expires'] >= date('U')) {
        // Actualizar la contraseña
        $stmt = $pdo->prepare('UPDATE sistema.usuarios SET password = ? WHERE email_institucional = ?');
        $stmt->execute([$newPassword, $resetRequest['email']]);

        // Eliminar el token de restablecimiento
        $stmt = $pdo->prepare('DELETE FROM sistema.password_resets WHERE token = ?');
        $stmt->execute([$token]);

        echo '<script>
            Swal.fire({
            icon: "success",
            title: "Exito",
            text: "¡Contraseña cambiada satisfactoriamente!.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if(result.value){                   
                window.location = "../index.php";
             }
            });
            </script>';

        
    } else {
        echo '<script>
        Swal.fire({
        icon: "error",
        title: "Error",
        text: "¡Token Invalido o ha expirado!.",
        showConfirmButton: true,
        confirmButtonText: "Cerrar"
        }).then(function(result){
        if(result.value){                   
            window.location = "../index.php";
         }
        });
        </script>';
        //echo 'Invalid or expired token.';
    }
}
