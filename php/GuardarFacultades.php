<form name="form-data" action="recibFacultades.php" method="POST">

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="form-label">Código Facultad</label>
            <input type="text" class="form-control" name="codigo" required='true' autofocus>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nombre Facultad</label>
            <input type="text" class="form-control" name="nombre" required='true'>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Estado</label>
            <input type="text" class="form-control" name="estado" required='true'>

        </div>
    </div>
    <div class="row justify-content-start text-center mt-5">
        <div class="col-12">
            <button class="btn btn-danger btn-block" id="btnEnviar">
                Guardar Facultad
            </button>
        </div>
    </div>
</form>