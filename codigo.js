$("#form-login").submit(function (e) {
    e.preventDefault();
    var codigo_usuario = $.trim($("#inputUsuario").val());
    var password = $.trim($("#inputPassword").val());

    //alert(password)
    
    if (codigo_usuario == "" || password == "") {
        Swal.fire({
            type: 'warning',
            title: 'Debe ingresar un usuario y/o contraseña',
        });
        return false;
    } else {
        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            datatype: 'json',
            assync: 'false',
            data: { codigo_usuario: codigo_usuario, password: password },
            success: function (data) {

                if (data == "null") {
                    Swal.fire({
                        type: 'error',
                        title: 'Usuario y/o contraseña incorrecta',
                    });
                } else {

                    objJsonEstado = JSON.parse(data);
                    

                    if (objJsonEstado['0'].estado == 'INACTIVO') {
                        Swal.fire({
                            type: 'error',
                            title: 'Accesso Denegado...Usuario inactivo',
                            confirmButtonColor: '#f0ad4e',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "index.php"
                            }
                        });
                    } else {

                        Swal.fire({
                            type: 'success',
                            title: 'Acceso',
                            text: 'Credenciales correctas',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Ingresar',
                            toast: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "php/principal.php"
                            }
                        });
                    }
                }
            }
        })
    }
});