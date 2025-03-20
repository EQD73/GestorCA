<?php
// File: send_reset_link.php
 
// Conexión a la base de datos
require 'db_connection.php';
include('scriptsweet.php');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['inputEmail'];
    //echo $email;
    // Verificar si el correo electrónico existe
    $stmt = $pdo->prepare('SELECT id FROM sistema.usuarios WHERE email_institucional = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    //echo $user;
    if ($user) {
        $token = bin2hex(random_bytes(50));
        //echo $token;
        $expires = date('U') + 1800; // Token válido por 30 minutos
        //echo $expires;
        // Guardar el token en la base de datos
        $stmt = $pdo->prepare('INSERT INTO sistema.password_resets (email, token, expires) VALUES (?, ?, ?)');
        $stmt->execute([$email, $token, $expires]);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->SMTPDebug = 0;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'gestorca.unicorsalud@gmail.com';                     //SMTP username
            $mail->Password   = 'higtmnifzshjjqid';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('gestorca.unicorsalud@gmail.com', '');
            $mail->addAddress($email);     //Add a recipient
            
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = mb_convert_encoding("Confirmacion de correo - Cambio de contraseña", 'ISO-8859-1');
            $mail->Body     = '<img src="http://190.242.60.213:89/GestorCA/images/Logo2.png"/>'. "<br>";
            $mail->Body    .= 'Click en el siguiente link para restablecer su contraseña: ';
            $mail->Body    .= 'http://http://190.242.60.213:89/GestorCA/php/reset_password.php?token=' . $token . "<br>";
            $mail->Body    .= 'Este link estará vigente por 30 minutos, transcurrido este tiempo no será válido';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            //echo 'Mensaje enviado con exito';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        
        //echo 'Un link para restablecer contraseña a sido enviado a su correo.';
        echo '<script>
            Swal.fire({
            icon: "success",
            title: "Exito",
            text: "¡Mensaje enviado con exito, Un link para restablecer contraseña a sido enviado a su correo.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if(result.value){                   
                window.location = "../index.php";
             }
            });
            </script>';
    
    } else {
        
        //echo 'No existe cuenta asociada a este correo.';
        echo '<script>
        Swal.fire({
        icon: "error",
        title: "Error",
        text: "No existe cuenta asociada a este correo.",
        showConfirmButton: true,
        confirmButtonText: "Cerrar"
        }).then(function(result){
        if(result.value){                   
            window.location = "recuperar.php";
         }
        });
        </script>';
    }
}
