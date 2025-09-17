<?php
$host = 'db';
$user = 'edocuser';
$password = 'userpassword';
$dbname = 'edoc';

// Crear conexión
$database = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}
?>
