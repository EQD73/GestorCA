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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.css" rel="stylesheet">
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

  <style>
    /* Overlay mejorado */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      /* fondo oscuro tipo modal */
      z-index: 1050;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }


    /* Contenedor del spinner */
    .spinner-content {
      text-align: center;
    }

    /* Esferas */
    .balls {
      position: relative;
      width: 100px;
      height: 100px;
      margin: 0 auto;
    }

    /*  .ball {
      width: 20px;
      height: 20px;
      background-color: red;
      border-radius: 50%;
      position: absolute;
      top: 40px;
      left: 40px;
      transform-origin: center;
      animation: ballspin 1.5s linear infinite;
      box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
    }
 */

    .ball {
      position: absolute;
      border-radius: 50%;
      background-color: red;
      transform-origin: center;
      animation: ballspin 1.5s linear infinite;
      box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
    }



    /* .ball1 {
      animation-delay: 0s;
    }

    .ball2 {
      animation-delay: 0.2s;
    }

    .ball3 {
      animation-delay: 0.4s;
    } */



    /* Tamaños decrecientes y delays */
    .ball1 {
      width: 24px;
      height: 24px;
      animation-delay: 0s;
    }

    .ball2 {
      width: 22px;
      height: 22px;
      animation-delay: 0.15s;
    }

    .ball3 {
      width: 20px;
      height: 20px;
      animation-delay: 0.3s;
    }

    .ball4 {
      width: 18px;
      height: 18px;
      animation-delay: 0.45s;
    }

    .ball5 {
      width: 16px;
      height: 16px;
      animation-delay: 0.6s;
    }

    .ball6 {
      width: 14px;
      height: 14px;
      animation-delay: 0.75s;
    }

    .ball7 {
      width: 12px;
      height: 12px;
      animation-delay: 0.9s;
    }

    .ball8 {
      width: 10px;
      height: 10px;
      animation-delay: 1.05s;
    }

    /* Animación de rotación */
    @keyframes ballspin {
      0% {
        transform: rotate(0deg) translateX(50px) rotate(0deg);
      }

      100% {
        transform: rotate(360deg) translateX(40px) rotate(-360deg);
      }
    }

    /* Texto "Validando" */
    .loading-text {
      font-size: 1.3rem;
      font-weight: bold;
      color: #dc3545;
      animation: blink 1.5s infinite;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Animación parpadeo */
    @keyframes blink {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.5;
      }
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.js"></script>

  <!-- Spinner Ultra-Pro -->
  <div id="spinnerOverlay" class="overlay d-none">
    <div class="spinner-content">
      <div class="balls">
        <div class="ball ball1"></div>
        <div class="ball ball2"></div>
        <div class="ball ball3"></div>
        <div class="ball ball4"></div>
        <div class="ball ball5"></div>
        <div class="ball ball6"></div>
        <div class="ball ball7"></div>
        <div class="ball ball8"></div>
      </div>

      <div class="loading-text mt-4">
        <i class="bi bi-person-circle me-2"></i> <!-- Ícono de usuario -->
        Validando usuario...
      </div>
    </div>
  </div>


  <script src="codigo.js"></script>
</body>

</html>