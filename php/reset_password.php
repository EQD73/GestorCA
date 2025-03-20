<?php

// File: reset_password.php

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
    <script src="https://kit.fontawesome.com/ffec4ec2ed.js" crossorigin="anonymous"></script>
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
                    $('#lock').addClass("fa fa-lock")
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
                    <h3 class="text-center font-weight-light my-2">Nueva Contraseña</h3>
                </div>
                
                <div class="card-body">
                    <form action="update_password.php" method="POST">
                        <input type="hidden" name="token" value=<?php echo $_GET['token']; ?>>
                        <div class="form-group">
                            <label class="small mb-1" for="nuevacontra">Nueva Contraseña</label>
                            <div class="input-group mb-3" id="show_hide_password">
                                <span class="input-group-text small" id="lock"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input class="form-control" name="password" type="password" placeholder="Ingrese Contraseña" />
                                <span class="input-group-text small"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>

                            </div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block">Cambiar Contraseña</button>
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