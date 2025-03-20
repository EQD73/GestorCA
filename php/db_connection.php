<?php

$host = 'localhost';
$db = 'postgres';
$user = 'postgres';
$pass = 'Killa2022';
$puerto = "5434";
//$charset = 'utf8mb4';

//$dsn = "mysql:host=$host;dbname=$db;";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    //$pdo = new PDO($dsn, $user, $pass, $options);
    $pdo = new PDO("pgsql:host=$host;port=$puerto;dbname=$db", $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
