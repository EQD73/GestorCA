$(document).ready(function() {
    let userTable = $('#userTable').DataTable({
        ajax: 'get_users.php',
        columns: [
            { data: 'id' },
            { data: 'codigo_usuario' },
            { data: 'nombres' },
            { data: 'apellidos' },
            { data: 'Celular' },
            { data: 'email_institucional' },
            { data: 'estado' },
            { data: 'codigo_rol' },
            { 
                data: null,
                render: function(data, type, row) {
                    return `<button class="btn btn-warning btn-sm editBtn" data-id="${row.id}">Editar</button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${row.id}">Eliminar</button>`;
                }
            }
        ]
    });

    // Añadir usuario
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'add_user.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario añadido',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#addUserModal').modal('hide');
                userTable.ajax.reload();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al añadir usuario',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });

    // Eliminar usuario
    $('#userTable').on('click', '.deleteBtn', function() {
        let userId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_user.php',
                    method: 'POST',
                    data: { id: userId },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado!',
                            'El usuario ha sido eliminado.',
                            'success'
                        );
                        userTable.ajax.reload();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al eliminar usuario',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        });
    });
});
