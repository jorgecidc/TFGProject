<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title></title>
</head>
<body>
    
</body>
</html>

<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php';

// Función para obtener las pistas disponibles
function obtener_pistas_disponibles() {
    global $conn;
    $pistas_disponibles = array();
    $sql = "SELECT * FROM Pista";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pistas_disponibles[] = $row;
        }
    }
    return $pistas_disponibles;
}

// Función para reservar una pista
function reservar_pista($pista_id, $fecha, $hora_inicio, $id_user) {
    global $conn;
    if (pista_disponible($pista_id, $fecha, $hora_inicio)) {
        $sql = "INSERT INTO Partido (fecha, hora_inicio, id_usuario, id_pista) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $fecha, $hora_inicio, $id_user, $pista_id);
        return $stmt->execute();
    }
    return false;
}

// Función para verificar la disponibilidad de la pista en una hora específica
function pista_disponible($pista_id, $fecha, $hora_inicio) {
    global $conn;
    $sql = "SELECT * FROM Partido WHERE id_pista = ? AND fecha = ? AND hora_inicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $pista_id, $fecha, $hora_inicio);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows == 0;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["pista_id"]) && isset($_GET["fecha"]) && isset($_GET["hora"])) {
    $pista_id = $_GET["pista_id"];
    $fecha = $_GET["fecha"];
    $hora_inicio = $_GET["hora"];
    $id_user = $_GET["id_usuario"];
    if (reservar_pista($pista_id, $fecha, $hora_inicio, $id_user)) {
        echo '<div id="overlay">
                <div id="loading-message">
                    <div class="spinner"></div>
                    <p>Realizando reserva...</p>
                </div>
              </div>';
        echo '<script>
                setTimeout(function() {
                    document.querySelector("#loading-message p").innerHTML = "Reserva realizada correctamente";
                    document.querySelector(".spinner").style.display = "none";
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 2000);
                }, 3000);
              </script>';
    } else {
        echo "Lo sentimos, la pista seleccionada no está disponible en la hora especificada.";
    }
}
?>
