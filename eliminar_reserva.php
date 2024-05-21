<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: iniciarSesion.php");
    exit;
}

// Verificar si se ha enviado un ID de reserva válido
if (isset($_POST['reserva_id'])) {
    // Incluir el archivo de configuración de la base de datos
    require_once 'config.php';

    // Obtener el ID de reserva de la solicitud POST
    $reserva_id = $_POST['reserva_id'];

    // Consulta SQL para eliminar la reserva de partido
    $sql = "DELETE FROM Partido WHERE id_partido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id);

    // Ejecutar la consulta preparada
    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de mis reservas
        header("Location: mis_reservas.php");
        exit;
    } else {
        // Si hay un error al eliminar la reserva, mostrar un mensaje de error
        echo "Error al eliminar la reserva de partido.";
    }

    // Cerrar la consulta preparada y la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Si no se proporcionó un ID de reserva válido, redirigir a la página de mis reservas
    header("Location: mis_reservas.php");
    exit;
}
?>
