<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión
$conexion = new mysqli("localhost", "root", "", "tienda_virtual");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Inicializamos el mensaje
$mensaje = "";
$clase = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';
    $nombre = $_POST["nombre"] ?? '';
    $apellidos = $_POST["apellidos"] ?? '';
    $correo = $_POST["correo"] ?? '';
    $fecha = $_POST["fecha_nacimiento"] ?? '';
    $genero = $_POST["genero"] ?? '';

    if (!empty($usuario) && !empty($contrasena) && !empty($correo)) {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (usuario, contrasena, nombre, apellidos, correo, fecha_nacimiento, genero)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssss", $usuario, $hash, $nombre, $apellidos, $correo, $fecha, $genero);
            if ($stmt->execute()) {
                $mensaje = "Usuario registrado correctamente.";
                $clase = "alert-success";
                header("location: login.html" );
            } else {
                $mensaje = "Error al registrar: " . $stmt->error;
                $clase = "alert-danger";
            }
            $stmt->close();
        } else {
            $mensaje = "Error en la consulta: " . $conexion->error;
            $clase = "alert-danger";
        }
    } else {
        $mensaje = "Los campos usuario, contraseña y correo son obligatorios.";
        $clase = "alert-warning";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro con Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Registro de Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="alert <?= $clase ?>"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" name="usuario" id="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Género</label>
            <select name="genero" id="genero" class="form-select">
                <option value="">--Selecciona--</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Registrarse</button>
    </form>
</div>

</body>
</html>
