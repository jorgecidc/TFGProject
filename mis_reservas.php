<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: iniciarSesion.php");
    exit;
}

// Incluir el archivo de configuración de la base de datos
require_once 'config.php';

// Consulta SQL para obtener las reservas de partidos del usuario actual
$sql = "SELECT Partido.id_partido , Pista.nombre AS pista_nombre, Partido.fecha, Partido.hora_inicio 
        FROM Partido
        INNER JOIN Pista ON Partido.id_pista = Pista.id_pista
        WHERE Partido.id_usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();

// Array para almacenar las reservas de partidos del usuario
$reservas_partidos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservas_partidos[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - Club de Pádel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="img/5592019.png">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo"><img class="logoImagen" src="./img/logo.png" alt="Logo del club"></div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="alquiler.php">Alquiler de Pista</a></li>
                    <li><a href="#">Alquiler de Clases</a></li>
                    <li><a href="mis_reservas.php">Mis Reservas</a></li> 
                    <li><a href="#"><?php echo htmlspecialchars($_SESSION['nombre']); ?></a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                    
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="reservas pista-rental">
            <div class="container">
                <h1>Mis Reservas de Partidos</h1>
                <div class="table-container">
                    <?php if (!empty($reservas_partidos)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Pista</th>
                                <th>Fecha</th>
                                <th>Hora de Inicio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas_partidos as $reserva): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reserva['id_partido']); ?></td>
                                <td><?php echo htmlspecialchars($reserva['pista_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($reserva['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($reserva['hora_inicio']); ?></td>
                                <td>
                                <form method="POST" action="eliminar_reserva.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reserva?')">
                                        <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva['id_partido']); ?>">
                                        <button type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>No tienes reservas de partidos.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Club de Pádel. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>


