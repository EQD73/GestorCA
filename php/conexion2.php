<?php
/*


================================
Este archivo se encarga de conectar a la base de datos
y traer un objeto PDO

================================
 */
$contraseña = "postgres";
$usuario = "postgres";
$nombreBaseDeDatos = "postgres";
# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
$rutaServidor = "127.0.0.1";
$puerto = "5432";
$pdo = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña);


