do<?php
    include('conexion.php');
    $idRegistros = $_REQUEST['id'];

    $DeleteRegistro = ("DELETE FROM sistema.estrategias_met WHERE codigo_estrategia= '" . $idRegistros . "' ");
    pg_query($conexion, $DeleteRegistro);
    ?>