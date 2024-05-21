<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['firstname'];
    $apellido = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM Usuario WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
        $stmt->close();
        exit;
    }

    $sql = "INSERT INTO Usuario (nombre, apellido, correo, contrasena) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $hashed_password);

    if ($stmt->execute()) {
        echo '<div id="overlay">
                <div id="loading-message">
                    <div class="spinner"></div>
                    <p>Registrando...</p>
                </div>
              </div>';
        echo '<script>
                setTimeout(function() {
                    document.querySelector("#loading-message p").innerHTML = "Registro completado exitosamente";
                    document.querySelector(".spinner").style.display = "none";
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 2000);
                }, 3000);
              </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
