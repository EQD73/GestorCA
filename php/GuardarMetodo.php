<form name="form-data" action="recibMetodo.php" method="POST">

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="form-label">Código Metodo</label>
            <input type="text" class="form-control" name="codigo" required='true' autofocus>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nombre Metodo</label>
            <input type="text" class="form-control" name="nombre" required='true'>
        </div>
        
    </div>
    <div class="row justify-content-start text-center mt-5">
        <div class="col-12">
            <button class="btn btn-danger btn-block" id="btnEnviar">
                Guardar Metodologia
            </button>
        </div>
    </div>
</form>