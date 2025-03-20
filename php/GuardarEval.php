<form name="form-data" action="recibEval.php" method="POST">

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="form-label">Momento</label>
            <input type="text" class="form-control" name="momento" required='true' autofocus>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">% actividades</label>
            <input type="text" class="form-control" name="poract" required='true'>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">% actividad final</label>
            <input type="text" class="form-control" name="poractfinal" required='true'>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">% corte</label>
            <input type="text" class="form-control" name="porcorte" required='true'>
        </div>
    </div>
    <div class="row justify-content-start text-center mt-5">
        <div class="col-12">
            <button class="btn btn-danger btn-block" id="btnEnviar">
                Guardar Evaluación
            </button>
        </div>
    </div>
</form>