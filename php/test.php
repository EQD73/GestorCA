<!-- Semana3p -->
<?php
        $fechai3p = strtotime($objfechas->s3_rangoi_p);
        $fechaf3p = date("d-m-Y", strtotime($objfechas->s3_rangof_p . "+ 1 days"));
        $fechaf3p = strtotime($fechaf3p);

        if ($objfechas->s3_descripcion_p <> " " &&  $objfechas->s3_tipoactividad_p == "Novedad") { ?>
            <div class="row border border-danger rounded mt-1">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-md-8 mt-1">
                        <input type="text" class="inputClass col-md-2" id="titulosem3p" name="titulosem3p" value="Semana 3" readonly>

                        <label class="col-md-1" for="rangoinicio3p">Del:</label>
                        <input type="text" class="col-md-3" id="rangoinicio3p" name="rangoinicio3p" value="<?php echo $objfechas->s3_rangoi_p; ?>" readonly>

                        <label for="rangofinal3p" class="col-md-1">Al:</label>
                        <input type="text" class="col-md-2" id="rangofinal3p" name="rangofinal3p" value="<?php echo $objfechas->s3_rangof_p; ?>" readonly>
                    </div>
                    <div class="col-md-4 mt-2">
                        <input type="text" class="form-control form-control sm" id="TipoActividad3p" name="TipoActividad3p" value="Novedad" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h6><span class="badge bg-danger">Descripción</span></h6>
                        <textarea class="form-control" id="DescripcionActSem3p" name="DescripcionActSem3p" placeholder="Descripcion" rows="6"><?php echo $objfechas->s3_descripcion_p; ?></textarea>
                    </div>
                </div>
                <div class="row" id="s3pdivopt2">
                    <div class="col-md-4 mt-2">
                        <h6><span class="badge bg-danger">Tipo Novedad</span></h6>
                        <select class="form-select form-select-sm" id="TipoNovedad3p" name="TipoNovedad3p" onfocus="showopt2s3p();" onchange="showopt2s3p();">
                            
                            <option value="<?php echo $objfechas->s3_tiponovedad_p; ?>" selected><?php if ($objfechas->s3_tiponovedad_p == "Fueradefecha") {
                                                                                                    echo "Registro de Actividad fuera de fecha";
                                                                                                } else if ($objfechas->s3_tiponovedad_p == "Reprogramacion") {
                                                                                                    echo "Reprogramación de Actividad Académica";
                                                                                                } ?></option>
                            <?php if ($objfechas->s3_tiponovedad_p == "Fueradefecha") { ?>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option>
                            <?php } else if ($objfechas->s3_tiponovedad_p == "Reprogramacion") { ?>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option> <?php } ?>
                            <?php if ($objfechas->s3_tiponovedad_p == " " or empty($objfechas->s3_tiponovedad_p)) { ?> 
                                <option value="">Escoge una opción</option>
                                <option value="Fueradefecha">Registro de Actividad fuera de fecha</option>
                                <option value="Reprogramacion">Reprogramación de Actividad Académica</option> <?php } ?>   
                        </select>
                    </div>
                </div>
                <script>
                    if (document.getElementById('TipoNovedad3p').value != " ") {
                        $("#TipoNovedad3p").focus();
                    }
                </script>
                <div class="row">
                    <div class="col-md-8 mt-2" id="s3pdivopt3" style="display: none">
                        <h6><span class="badge bg-danger">Justificación</span></h6>
                        <textarea class="form-control" id="justificasem3p" name="justificasem3p" placeholder="Justificación" rows="2"><?php echo $objfechas->s3_justifica_nov_p; ?></textarea>
                    </div>
                    <div class="col-md-4 mt-2" id="s3pdivopt4" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Desarrollo Actividad Novedad</span></h6>
                        <input type="date" class="form-control form-control sm" id="fechanov3p" name="fechanov3p" value="<?php echo $objfechas->s3_fechanovedad_p; ?>">
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mt-2" id="s3pdivopt7" style="display: none">
                        <h6><span class="badge bg-danger">Justificación Reprogramación</span></h6>
                        <textarea class="form-control" id="justificarsem3p" name="justificarsem3p" placeholder="Justificación" rows="2"><?php echo $objfechas->s3_justifica_reprog_p; ?></textarea>
                    </div>
                    <div class="col-md-6 mt-2" id="s3pdivopt5" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 1</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3pfecharep1" name="s3pfecharep1" value="<?php echo $objfechas->s3_fechareprog1_p; ?>">
                    </div>
                    <div class="col-md-6 mt-2" id="s3pdivopt6" style="display: none">
                        <h6><span class="badge bg-danger">Fecha Reprogramación 2</span></h6>
                        <input type="date" class="form-control form-control sm" id="s3pfecharep2" name="s3pfecharep2" value="<?php echo $objfechas->s3_fechareprog2_p; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>