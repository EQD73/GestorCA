<?php

require "conexion.php";

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" type="text/css" href="plugins/sweetAlert2/sweetalert2.min.css" />
  <link rel="shortcut icon" href="images/faviconV2.png" type="image/x-icon">




  <title>Gestor CA - Restablecer Contraseña | Unicorsalud 2024</title>

  <script>
    $(document).ready(function() {
      $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("fa-eye-slash");
          $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("fa-eye-slash");
          $('#show_hide_password i').addClass("fa-eye");
        }
      });
    });
  </script>



</head>

<body>
  <div class="container col-lg-5 d-flex flex-column align-items-center justify-content-center
          min-vh-100">
    <div class="px-lg-5">
      <img src="../images/Logo.png" class="img-fluid" />
    </div>
    <div class="px-lg-5">
      <p class="h3">Software Gestor de Contenidos</p>
    </div>
    <div class="align-self-center w-100 px-lg-4 py-lg-4 p-4" id="login">
      <div class="card shadow-lg border-0 rounded-lg mt-3">
        <div class="card-header">
          <h3 class="text-center font-weight-light my-2">Reestablecer Contraseña</h3>
        </div>
        <div class="card-body">
          <form action="send_reset_link.php" method="POST">
            <div class="form-group">
              <label class="small mb-1" for=" inputEmail">Correo Electrónico</label>
              <div class="input-group mb-3">
                
                  <span class="input-group-text small"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                
                <input class="form-control" id="inputEmail" name="inputEmail" type="email" placeholder="Ingresar Correo" autofocus required />
              </div>
            </div>

            
            <div class="form-group">
              <button type="submit" class="btn btn-danger btn-block">Enviar</button>
            </div>

          </form>
        </div>
      </div>
    </div>


  </div>

  <!-- Optional JavaScript -->
  <!-- Popper.js first, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <script src="plugins/sweetAlert2/sweetalert2.all.min.js"></script>
  <script src="codigo.js"></script>


</body>

</html>
