$("#form-login").submit(function (e) {
    e.preventDefault();
    var codigo_usuario = $.trim($("#inputUsuario").val());
    var password = $.trim($("#inputPassword").val());

    if (codigo_usuario === "" || password === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar un usuario y/o contraseña',
        });
        return false;
    }

    $("#spinnerOverlay").removeClass('d-none');

    $.ajax({
        url: 'php/login.php',
        type: 'POST',
        dataType: 'json',
        async: true,
        data: { codigo_usuario, password },
        success: function (data) {
            setTimeout(() => {
                $("#spinnerOverlay").addClass('d-none');

                if (data == null || data.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario y/o contraseña incorrecta',
                    });
                } else {
                    if (data[0].estado == 'INACTIVO') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Acceso Denegado...Usuario inactivo',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Ok',
                        }).then(() => {
                            window.location.href = "index.php";
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Acceso',
                            text: 'Credenciales correctas',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Ingresar',
                        }).then(() => {
                            window.location.href = "php/principal.php";
                        });
                    }
                }
            }, 3000); // 3 segundos de espera
        },

        error: function () {
            $("#spinnerOverlay").addClass('d-none');
            Swal.fire({
                icon: 'error',
                title: 'Error en la comunicación con el servidor',
            });
        }
    });
});
