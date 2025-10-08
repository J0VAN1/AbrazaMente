<?php
$host = 'db';
$user = 'charmanderuser';
$password = 'userpassword';
$dbname = 'charmander';

// Crear conexión
$database = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}
$database->set_charset("utf8mb4");

?>
