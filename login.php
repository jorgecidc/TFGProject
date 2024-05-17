<?php
session_start();
include 'config.php'; // Archivo de configuración para la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Obtener la contraseña encriptada de la base de datos
    $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, contrasena FROM Usuario WHERE correo = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $nombre, $apellido, $hashed_password);
        $stmt->fetch();

        // Verificar si la contraseña ingresada coincide con la contraseña almacenada en la base de datos
        if (password_verify($password, $hashed_password)) {
            // Guardar los datos en la sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;

            // Redirigir al index.php
            header("Location: index.php");
            exit();
        } else {
            // Redirigir al inicio de sesión con mensaje de error
            header("Location: iniciarSesion.php?error=1");
            exit();
        }
    } else {
        // Redirigir al inicio de sesión con mensaje de error
        header("Location: iniciarSesion.php?error=1");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
