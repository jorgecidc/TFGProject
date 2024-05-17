
<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php';
session_start(); 

// Función para obtener las pistas disponibles
function obtener_pistas_disponibles() {
    global $conn; // Utiliza la conexión a la base de datos definida en config.php
    
    $pistas_disponibles = array();
    
    // Consulta SQL para obtener las pistas disponibles
    $sql = "SELECT * FROM Pista ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pistas_disponibles[] = $row;
        }
    }
    
    return $pistas_disponibles;
}


// Función para reservar una pista
function reservar_pista($pista_id, $fecha, $hora_inicio, $id_user)
{
    global $conn;
    // Verificar disponibilidad de la pista en la hora seleccionada
    if (pista_disponible($pista_id, $fecha, $hora_inicio,$id_user)) {

        // Insertar la reserva en la base de datos
        $sql = "INSERT INTO Partido (fecha, hora_inicio, id_usuario, id_pista) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $fecha, $hora_inicio, $id_user, $pista_id);


        if ($stmt->execute()) {
            return true; // Reserva exitosa
        } else {
            return false; // Error al realizar la reserva
        }
    } else {
        return false; // La pista no está disponible en la hora especificada
    }
}

// Función para verificar la disponibilidad de la pista en una hora específica
function pista_disponible($pista_id, $fecha, $hora_inicio)
{
    global $conn;
    $sql = "SELECT * FROM Partido WHERE id_pista = ? AND fecha = ? AND hora_inicio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $pista_id, $fecha, $hora_inicio);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return false; // La pista está ocupada en la hora especificada
    } else {
        return true; // La pista está disponible en la hora especificada
    }
}

// Verificar si se ha enviado una solicitud GET y los parámetros necesarios están presentes
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["pista_id"]) && isset($_GET["fecha"]) && isset($_GET["hora"])) {
    // Obtener el ID de la pista, la fecha y la hora de inicio de la URL
    $pista_id = $_GET["pista_id"];
    $fecha = $_GET["fecha"];
    $hora_inicio = $_GET["hora"];
    $id_user = $_GET["id_usuario"];
    // Realizar la reserva de la pista
    if (reservar_pista($pista_id, $fecha, $hora_inicio, $id_user)) {
        
        header("Location: index.php");
            exit();
    } else {
        echo "Lo sentimos, la pista seleccionada no está disponible en la hora especificada.";
    }
} else {
}
?>
