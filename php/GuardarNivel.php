<form name="form-data" action="recibNivel.php" method="POST">

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="form-label">Id</label>
            <input type="text" class="form-control" name="codigo" required='true' autofocus readonly>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nivel1:</label>
            <input type="text" class="form-control" name="nivel1" required='true' readonly>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nivel2:</label>
            <input type="text" class="form-control" name="nivel2" required='true' readonly>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nivel3:</label>
            <input type="text" class="form-control" name="nivel3" required='true' readonly>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nivel4</label>
            <input type="text" class="form-control" name="nivel4" required='true' readonly>
        </div>
    </div>
    <div class="row justify-content-start text-center mt-5">
        <div class="col-12">
            <button class="btn btn-danger btn-block" id="btnEnviar" disabled>
                Guardar Nivel
            </button>
        </div>
    </div>
</form>