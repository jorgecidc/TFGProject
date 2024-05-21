<?php
include 'config.php'; // Archivo que incluye la conexión a la base de datos

if (!isset($_GET['id'])) {
    header('Location: gestionarUsuarios.php');
    exit;
}

$userId = $_GET['id'];

// Eliminar los registros asociados en la tabla partido
$deletePartidoQuery = "DELETE FROM Partido WHERE id_usuario = ?";
if ($stmt = $conn->prepare($deletePartidoQuery)) {
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        echo "<p>Error al eliminar los registros asociados en la tabla partido: " . htmlspecialchars($stmt->error) . "</p>";
    }
    $stmt->close();
} else {
    echo "<p>Error en la preparación de la consulta para eliminar los registros asociados en la tabla partido: " . htmlspecialchars($conn->error) . "</p>";
}

// Eliminar el usuario
$deleteUsuarioQuery = "DELETE FROM Usuario WHERE id_usuario = ?";
if ($stmt = $conn->prepare($deleteUsuarioQuery)) {
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        header('Location: gestionUsuarios.php');
        exit;
    } else {
        echo "<p>Error al eliminar el usuario: " . htmlspecialchars($stmt->error) . "</p>";
    }
    $stmt->close();
} else {
    echo "<p>Error en la preparación de la consulta para eliminar el usuario: " . htmlspecialchars($conn->error) . "</p>";
}
?>
