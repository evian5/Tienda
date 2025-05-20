<?php
session_start();
include 'conexion.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($usuario) || empty($contrasena)) {
        echo "Usuario y contraseña son obligatorios.";
        exit;
    }

    // Consultar usuario en la base de datos
    $sql = "SELECT contrasena FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    // Validar existencia del usuario
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        if (password_verify($contrasena, $hash)) {
            $_SESSION['usuario'] = $usuario;
            echo "Login correcto. Redirigiendo...";

            // Redirigir a la página principal
            header("Location: tienda.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado o no esta registrado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
