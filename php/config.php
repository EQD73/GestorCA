<?php

$host = "localhost";
$user = "postgres";
$password = "postgres";
$dbname = "postgres";
$port='5432';
$con = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$con) {
   die('Connection failed.');
}

