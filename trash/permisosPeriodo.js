f/* unction showPermisos() {     
    Swal.fire({
        icon: "info",
        title: "Cuidado...",
        toast: false,
        position: "center",
        text: "¡Usted no tiene permisos para ingresar a esta opción!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

    }).then((result) => {
        if (result.value) {
            window.location.href = "principal.php"
        }
    });
} */