<!-- Semana18 -->
<?php
$fechai18 = strtotime($objfechas->s18_rangoi);
$fechaf18 = date("d-m-Y", strtotime($objfechas->s18_rangof . "+ 1 days"));
$fechaf18 = strtotime($fechaf18);

if ($fechahoy > $fechaf18 && ($objfechas->s18_tipoactividad == " " || $objfechas->s18_tipoactividad == null)) { ?>
    <div class="row border border-danger rounded">
        <div class="row">
            <div class="col-md-8 mt-2">
                <input type="text" class="inputClass col-md-2" id="titulosem18" name="titulosem18" value="Semana 18" readonly>

                <label class="col-md-1" for="rangoinicio18">Del:</label>
                <input type="text" class="col-md-2" id="rangoinicio18" name="rangoinicio18" value="<?php echo $objfechas->s18_rangoi; ?>" readonly>

                <label for="rangofinal18" class="col-md-1">Al:</label>
                <input type="text" class="col-md-2" id="rangofinal18" name="rangofinal18" value="<?php echo $objfechas->s18_rangof; ?>" readonly>
            </div>
            <div class="col-md-4 mt-2">
                <input type="text" class="form-control form-control sm" id="TipoActividad18" name="TipoActividad18" value="Novedad" readonly>
            </div>
        </div>
        <div class="row" id="s18divopt1">
            <div class="col-md-12 mt-2">
                <h6><span class="badge bg-danger">Descripción</span></h6>
                <textarea class="form-control" id="DescripcionActSem18" name="DescripcionActSem18" placeholder="Descripcion" rows="6" required></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Descripción de la actividad.</div>
            </div>
        </div>
        <div class="row" id="s18divopt2">
            <div class="col-md-4 mt-2">
                <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                <select class="form-select form-select-sm" id="TipoNovedad18" name="TipoNovedad18" onchange="showopt2s18()" required>
                    <option value="" selected></option>
                    <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                    <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                    <div class="valid-feedback">Campo Validado.</div>
                    <div class="invalid-feedback">Por favor ingresar Tipo de Novedad.</div>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2" id="s18divopt3" style="display: none">
                <h6><span class="badge bg-danger">Justificación</span></h6>
                <textarea class="form-control" id="justificasem18" name="justificasem18" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-4 mt-2" id="s18divopt4" style="display: none">
                <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                <input type="date" class="form-control form-control sm" id="fechanov18" name="fechanov18">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha Actividad Novedad.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2" id="s18divopt7" style="display: none">
                <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                <textarea class="form-control" id="justificarsem18" name="justificarsem18" placeholder="Justificación" rows="2"></textarea>
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Justificación.</div>
            </div>
            <div class="col-md-3 mt-2" id="s18divopt5" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                <input type="date" class="form-control form-control sm" id="s18fecharep1" name="s18fecharep1">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 1.</div>
            </div>
            <div class="col-md-3 mt-2" id="s18divopt6" style="display: none">
                <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                <input type="date" class="form-control form-control sm" id="s18fecharep2" name="s18fecharep2">
                <div class="valid-feedback">Campo Validado.</div>
                <div class="invalid-feedback">Por favor ingresar Fecha reprogramación 2.</div>
            </div>
        </div>
    </div>
<?php }
