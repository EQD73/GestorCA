<?php
function generarContrasena($listaPalabras, $longitud = 1) {
    $contrasena = '';
    $numPalabras = count($listaPalabras);

    // Mezclar las palabras aleatoriamente
    shuffle($listaPalabras);

    // Seleccionar un número determinado de palabras
    for ($i = 0; $i < $longitud; $i++) {
        if ($i < $numPalabras) {
            $contrasena .= $listaPalabras[$i];
        }
    }

    // Añadir un número aleatorio para mayor seguridad
    $contrasena .= rand(0, 9999);

    // Añadir un carácter especial aleatorio
    $caracteresEspeciales = '$*';
    $contrasena .= $caracteresEspeciales[rand(0, strlen($caracteresEspeciales) - 1)];

    return $contrasena;
}

// Lista de palabras
$listaPalabras = ['Soporte', 'Reporte', 'Regional', 'Equipo', 'Monitor', 'Registro', 'Control', 'Bienestar'];

// Generar la contraseña
$contrasenaGenerada = generarContrasena($listaPalabras);

// Imprimir la contraseña generada
echo "La contraseña generada es: " . $contrasenaGenerada;
?>