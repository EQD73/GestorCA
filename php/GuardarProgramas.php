<form name="form-data" action="recibProgramas.php" method="POST">

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="form-label">Código Programa</label>
            <input type="text" class="form-control" name="codigo" required='true' autofocus>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Nombre Programa</label>
            <input type="text" class="form-control" name="nombre" required='true'>
        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Código Sede</label>
            <!-- <input type="text" class="form-control" name="estado" required='true'> -->

            <select class="form-select form-select-sm" aria-label="Default select example" name="sede">
                <option selected>Escoger Opción</option>
                <?php
                while ($obj = pg_fetch_object($resultado_qs)) { ?>
                    <option value="<?php echo $obj->codigo_sede; ?>"><?php echo $obj->codigo_sede;
                                                                        echo "  |  ";
                                                                        echo $obj->nombre_sede; ?></option>
                <?php
                }
                ?>
            </select>

        </div>
        <div class="col-md-12 mt-2">
            <label for="name" class="form-label">Código Coordinador/Director Programa</label>


            <select class="form-select form-select-sm" aria-label="Default select example" name="codigoc" id="codigoc">
                <option selected disabled>Escoger Opción</option>
                <?php while ($obj2 = pg_fetch_object($resultado_qus)) { ?>
                    <option
                        value="<?php echo $obj2->codigo_usuario; ?>"
                        data-nombre="<?php echo htmlspecialchars($obj2->nomcompleto); ?>">
                        <?php echo $obj2->codigo_usuario . "  |  " . $obj2->nomcompleto; ?>
                    </option>
                <?php } ?>
            </select>

        </div>
        <input type="hidden" name="nombrecompleto" id="nombrecompleto">
    </div>
    <div class="row justify-content-start text-center mt-5">
        <div class="col-12">
            <button class="btn btn-danger btn-block" id="btnEnviar">
                Guardar Programa
            </button>
        </div>
    </div>
</form>