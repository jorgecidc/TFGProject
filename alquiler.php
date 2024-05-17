<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alquiler de Pistas - Club de Pádel</title>
    <link rel="stylesheet" href="style.css">
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
                    <li><a href="iniciarSesion.php">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="pista-rental">
            <div class="container">
                <h1>Alquiler de Pistas</h1>
                <!-- Formulario para seleccionar fecha y hora de inicio -->
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
                        foreach ($pistas_disponibles as $pista) {
                            echo '<div class="pista"><a href="reservar_pista.php?pista_id=' . $pista['id_pista'] . '&fecha=' . $fecha . '&hora=' . $hora . '&id_usuario=' . $_SESSION['id_usuario'] . '">' . $pista['nombre'] . '</a></div>';

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
