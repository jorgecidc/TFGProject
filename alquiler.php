<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alquiler de Pistas - Club de Pádel</title>
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
        <section class="pista-rental">
            <div class="container">
                <h1>Alquiler de Pistas</h1>
                <form action="alquiler.php" method="get">
                    <label for="fecha">Fecha de inicio:</label>
                    <input type="date" id="fecha" name="fecha" required>
                    <label for="hora">Hora de inicio:</label>
                    <input type="time" id="hora" name="hora" required>
                    <button type="submit" name="submit" value="true">Seleccionar</button>
                </form>
                <div class="pistas-grid">
                    <?php
                    require_once "reservar_pista.php";

                    // Lógica para mostrar las pistas disponibles después de enviar los datos
                    if (isset($_GET['submit']) && $_GET['submit'] == 'true') {
                        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
                        $hora = isset($_GET['hora']) ? $_GET['hora'] : '';
                        $pistas_disponibles = obtener_pistas_disponibles();
                        foreach ($pistas_disponibles as $index => $pista) {
                            echo '<div class="pista">';
                            echo '<span>Pista ' . ($index + 1) . '</span>';
                            echo '<a href="reservar_pista.php?pista_id=' . $pista['id_pista'] . '&fecha=' . $fecha . '&hora=' . $hora . '&id_usuario=' . $_SESSION['id_usuario'] . '"><img src="./img/pista.png" alt="' . $pista['nombre'] . '"></a>';
                            echo '</div>';
                        }
                    }
                    ?>
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
