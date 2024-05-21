<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Pádel - Inicio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="img/5592019.png">
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
        <section class="club-description">
            <div class="container">
                <h1>Bienvenido a Pádel 360</h1>
                <p>¡Reserva tus pistas y clases de pádel con nosotros! Ofrecemos una experiencia única para todos los aficionados al pádel. Nuestras instalaciones cuentan con las mejores pistas y entrenadores expertos para mejorar tu juego.</p>
                <div class="justificacion">
                    <h2>Justificación</h2>
                    <p>La creación de este club responde a la creciente demanda de soluciones tecnológicas en el ámbito deportivo, especialmente en el pádel. Se busca mejorar la gestión del club, optimizar recursos y brindar una experiencia más satisfactoria a los usuarios. La plataforma de gestión ofrecerá una herramienta poderosa para mejorar la operatividad y la experiencia del usuario en los clubes de pádel, contribuyendo a su crecimiento y desarrollo a largo plazo.</p>
                </div>
                <div class="history">
                    <h2>Historia del Pádel</h2>
                    <p>El pádel es un deporte que se originó en México a finales de los años 60, aunque su popularidad se extendió rápidamente a España y otros países latinoamericanos en las décadas siguientes. Combina elementos del tenis, squash y bádminton, y se juega en parejas en una pista cerrada con paredes de vidrio o malla metálica.</p>
                    <p>En las últimas décadas, el pádel ha experimentado un crecimiento significativo, convirtiéndose en uno de los deportes más populares en muchos países. Su accesibilidad, facilidad para aprender y divertida dinámica de juego lo hacen atractivo para personas de todas las edades y niveles de habilidad.</p>
                </div>
                <div class="services">
                    <h2>Nuestros Servicios</h2>
                    <p>Además de ofrecer alquiler de pistas y clases de pádel, nuestro club proporciona servicios adicionales para mejorar tu experiencia, como eventos sociales, torneos internos y una tienda con todo el equipamiento que necesitas para jugar.</p>
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
