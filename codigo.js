$("#form-login").submit(function (e) {
    e.preventDefault();
    var codigo_usuario = $.trim($("#inputUsuario").val());
    var password = $.trim($("#inputPassword").val());

    if (codigo_usuario == "" || password == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar un usuario y/o contraseña',
        });
        return false;
    } else {
        // Mostrar spinner
        $("#spinnerOverlay").removeClass('d-none');

        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            dataType: 'json', // corregido datatype -> dataType (ojo mayúscula T)
            async: true, // corregido assync -> async: true
            data: { codigo_usuario: codigo_usuario, password: password },
            success: function (data) {
                setTimeout(() => { // damos tiempo al spinner
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
                                confirmButtonColor: '#f0ad4e',
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "index.php";
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Acceso',
                                text: 'Credenciales correctas',
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'Ingresar',
                                toast: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "php/principal.php";
                                }
                            });
                        }
                    }
                }, 4000); // 0.8 segundos para mostrar spinner
            },
            error: function () {
                $("#spinnerOverlay").addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la comunicación con el servidor',
                });
            }
        });
        //$("#spinnerOverlay").addClass('d-none');    // Ocultar spinner después de login correcto
    }
});
