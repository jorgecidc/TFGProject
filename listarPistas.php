<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: iniciarSesion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pistas - Club de Pádel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo"><img class="logoImagen" src="./img/logo.png" alt="Logo del club"></div>
            <nav>
            <ul>
                    <li><a href="indexAdmin.php">Inicio</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <li><a href="listarPistas.php">Listar Pistas</a></li>
                        <li><a href="gestionUsuarios.php">Administrar Usuarios</a></li>
                        <li><a href="#"><?php echo htmlspecialchars($_SESSION['nombre']); ?></a></li>
                        <li><a href="logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="iniciarSesion.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="container">
            <h1>Listado de Alquileres</h1>
            <form method="GET" action="listarPistas.php">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha">
                
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora">
                
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario">
                
                <input type="submit" value="Filtrar">
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Usuario</th>
                        <th>Pista</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtiene los filtros de búsqueda
                    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
                    $hora = isset($_GET['hora']) ? $_GET['hora'] : '';
                    $usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';

                    // Construye la consulta con filtros opcionales
                    $query = "
                        SELECT Partido.fecha, Partido.hora_inicio, Usuario.nombre AS nombre_usuario, Partido.id_pista AS nombre_pista
                        FROM Partido
                        JOIN Usuario ON Partido.id_usuario = Usuario.id_usuario
                        WHERE 1=1
                    ";

                    if (!empty($fecha)) {
                        $query .= " AND Partido.fecha = '$fecha'";
                    }

                    if (!empty($hora)) {
                        $query .= " AND Partido.hora_inicio = '$hora'";
                    }

                    if (!empty($usuario)) {
                        $query .= " AND Usuario.nombre LIKE '%$usuario%'";
                    }

                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['hora_inicio']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nombre_usuario']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nombre_pista']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay alquileres registrados</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Club de Pádel. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
