<?php
require "php/conexion.php";
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




  <title>Gestor CA - Inicio de Sesión | Unicorsalud 2024</title>

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

<style>
  h2 {
    text-align: center;
  }
</style>



</head>

<body>
  <section>
    <div class="row g-0">
      <div class="col-lg-7 d-none d-lg-block">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item img-1 min-vh-100 active">
              <div class="carousel-caption d-none d-md-block">
                <h5 class="font-weight-bold">Consignador Académico</h5>
                <a class="text-muted text-decoration-none">Gestor de Contenidos Académicos</a>
              </div>
            </div>
            <div class="carousel-item img-2 min-vh-100">
              <div class="carousel-caption d-none d-md-block">
                <h5 class="font-weight-bold">Registro de Actividades Academicas</h5>
                <a class="text-muted text-decoration-none">Gestor de contenidos academicos</a>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
          </a>
        </div>
      </div>
      <div class="col-lg-5 d-flex flex-column align-items-end min-vh-100">
        <div class="px-lg-5">
          <img src="images/Logo.png" class="img-fluid" />
        </div>
        <div class="col-lg-12 d-flex flex-column">
        <h2>Software Gestor de Contenidos</h2>
          <!-- <p class="h2">Software Gestor de Contenidos</p> -->
        </div>
        <div class="align-self-center w-100 px-lg-4 py-lg-4 p-4" id="login">
          <div class="card shadow-lg border-0 rounded-lg mt-3">
            <div class="card-header">
              <h3 class="text-center font-weight-light my-2">Inicio de Sesión</h3>
            </div>
            <div class="card-body">
              <form id="form-login" method="POST">
                <div class="form-group">
                  <label class="small mb-1" for=" inputUsuario">Usuario</label>
                  <div class="input-group-prepend">
                    <span class="input-group-text"><span class="fa fa-user"></span></span>
                    <input class="form-control" id="inputUsuario" name="usuario" type="text" placeholder="Ingrese Usuario" autofocus />
                  </div>
                </div>

                <div class="form-group">
                  <label>Contraseña</label>
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <span class="fa fa-lock"></span></span>
                    <div class="input-group" id="show_hide_password">
                      <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Ingrese Contraseña" />
                      <div class="input-group-addon">
                        <span class="input-group-text">
                          <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-danger btn-block">Ingresar</button>
                </div>
                <div class="bottom-action clearfix">
                  <label class="float-left form-check-label">
                    <input type="checkbox" class="form-check-input"> Recordarme</label>
                  <a href="php/recuperar.php" id="olvidar" class="float-right" title="Recuperar Clave">Olvidaste tu contraseña?</a>
                  
                </div>
              </form>
            </div>
          </div>
        </div>


      </div>
  </section>
  <!-- Optional JavaScript -->
  <!-- Popper.js first, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <script src="plugins/sweetAlert2/sweetalert2.all.min.js"></script>
  <script src="codigo.js"></script>
</body>

</html>