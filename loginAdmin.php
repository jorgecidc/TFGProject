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
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <li><a href="alquiler.php">Alquiler de Pista</a></li>
                        <li><a href="#">Alquiler de Clases</a></li>
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
        <section class="login-section">
            <div class="container">
                <h1>Administrador</h1>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo '<p style="color: red;">Usuario o contraseña incorrectos</p>';
                }
                ?>
                <form action="loginAdministrador.php" method="post">
                    <input type="text" name="username" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Iniciar Sesión</button>
                </form>
                <p>¿No tienes cuenta? <a href="registro.php">Registrarse</a></p>
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
