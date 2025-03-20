
<form name="form-data" action="recibPeriodo.php" method="POST">

    <div class="row">
      <div class="col-md-12">
          <label for="name" class="form-label">Codigo Periodo</label>
          <input type="text" class="form-control" name="codigo" required='true' autofocus>
      </div>
      <div class="col-md-12 mt-2">
          <label for="name" class="form-label">Nombre Periodo</label>
          <input type="text" class="form-control" name="nombre" required='true'>
      </div>
      <div class="col-md-12 mt-2">
          <label for="totalsem" class="form-label">Total Semanas</label>
          <input type="text" class="form-control" name="totalsem" value='16'>
      </div>
      <div class="col-md-12 mt-2">
          <label for="fechainicio" class="form-label">Fecha inicio Periodo</label>
          <input type="date" class="form-control form-control sm" id="fechainicio" name="fechainicio">
      </div>
      <div class="col-md-12 mt-2">
          <label for="fechafinal" class="form-label">Fecha final Periodo</label>
          <input type="date" class="form-control form-control sm" id="fechafinal" name="fechafinal">
      </div>
      <div class="col-md-12 mt-2">
         <label for="estado" class="form-label">Estado</label>
         <select class="form-select form-select-sm" id="estado" name="estado">
            <option value="" selected>Escoger Opción</option>
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
        </select>
     </div>

    </div>
      <div class="row justify-content-start text-center mt-5">
          <div class="col-12">
              <button class="btn btn-danger btn-block" id="btnEnviar">
                  Guardar Periodo
              </button>
          </div>
      </div>
</form>
