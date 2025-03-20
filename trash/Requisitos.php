<?php

include('conexion.php');
?>

<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
</head>
<body>
    

<label for="formGroup" class="form-label">Requisitos</label>

<select class="form-select" name="requisitos[]" multiple id="requisitos" data-placeholder="Escoger Opción">

    <?php

    $query_temp = "SELECT * FROM sistema.temporal WHERE id='1' ";
    $resultado_temp = pg_query($conexion, $query_temp);
    $obj_temp = pg_fetch_object($resultado_temp);
    $value = strval($obj_temp->valor1);

    // select de tabla asignaturas

    $query_asignaturas2 = "SELECT * FROM sistema.asignaturas WHERE codigo_programa='$value' ORDER BY codigo_asignatura ASC, grupo ASC ";
    $resultado_qa2 = pg_query($conexion, $query_asignaturas2);

    while ($obj = pg_fetch_object($resultado_qa2)) { ?>
        <option value="<?php echo $obj->codigo_asignatura;
                        echo " - ";
                        echo $obj->nom_asignatura; ?>"><?php echo $obj->codigo_asignatura; echo "  |  ";
                                                                                                    echo $obj->nom_asignatura;
                                                                                                    echo "  |  ";
                                                                                                    echo $obj->grupo; ?></option>

    <?php

    }

    ?>

</select>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#requisitos').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    })   
    </script>

</body>   
 




</html>

