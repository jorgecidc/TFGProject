<?php
$servername = "db";
$username = "jorge_cid";
$password = "AgQXZMCwgTQi";
$dbname = "jorge_cid_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

